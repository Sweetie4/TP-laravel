<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public static function store($contract_id){
        $contract = Contract::where('id',$contract_id)->with('tenant','box', 'owner')->first();
        $start_date = $contract->start_date; 
        $end_date = $contract->end_date; 
        $interval = $start_date->diff($end_date);
        $nb_month = $interval->y * 12 + $interval->m;
        for ($i = 1; $i<$nb_month+1; $i++){
            if (!$start_date instanceof \Carbon\Carbon) {
                $start_date = \Carbon\Carbon::parse($start_date);
            }
            $start_date->addMonth();
            $start_month = $start_date->copy()->firstOfMonth()->toDateString();
            $end_month = $start_date->copy()->lastOfMonth()->toDateString();
            $file_name = "facture_".$contract->tenant->first_name."_".$contract->tenant->last_name."_".$contract->box->id."_".date('Y-m-d').".pdf";
            $data =[
                'tenant' =>  $contract->tenant,
                'user' => $contract->owner,
                'box' => $contract->box, 
                'dates'=>[ 
                    $start_month,  
                    $end_month
                ],
                'title'=>explode('.pdf',$file_name)[0],
            ];
            $pdf = Pdf::loadView('bill.pdf.bill', $data);
            $content = $pdf->download()->getOriginalContent();
            Storage::disk('public')->put($file_name, $content);
            Payment::create([
                'contract_id' => $contract_id,
                'due_date' => $start_date->toDateString(),
                'file_path'=>Storage::url($file_name),
            ]);
            
        }
    }

    public function show($owner_id,$month){
        // Rent is due at the beginning of the NEXT month
        // So we take payment for the previous month
        $finish_after = date("Y-m-01 00:00:00", strtotime("-1 month",strtotime(DateTime::createFromFormat("m-Y", $month)->format('Y-m-d')))); //Take contract that include the previous month
        $start_before = date("Y-m-t 00:00:00", strtotime(DateTime::createFromFormat("m-Y", $month)->format('Y-m-d'))); //Exclude contracts that start after this month
        $contracts = Contract::where([
                ['owner_id',$owner_id],
                ['start_date','<=', $start_before],
                ['end_date','>=', $finish_after],
            ])
            ->with('payments','tenant','box', 'model')
            ->get();
        $payments =[];
        foreach ($contracts as $contract){
            $contract_payments = $contract->payments;
            foreach ($contract_payments as $payment){
                if ($month == date("m-Y",strtotime($payment->due_date))||$month == date("m-Y",strtotime("+1 month",strtotime($payment->due_date)))){
                    $payments[] = ['payment'=>$payment, 'contract'=>$contract];
                }

            }
        }
        return view('payment.list', 
            ['payments'=>$payments, 'owner_id'=>$owner_id, 'month'=>$month]
        );
    }

    public function showBills($owner_id,$month){
        // Rent is due at the beginning of the NEXT month
        // So we take payment for the previous month
        $finish_after = date("Y-m-01 00:00:00", strtotime("-1 month",strtotime(DateTime::createFromFormat("m-Y", $month)->format('Y-m-d')))); //Take contract that include the previous month
        $start_before = date("Y-m-t 00:00:00", strtotime(DateTime::createFromFormat("m-Y", $month)->format('Y-m-d'))); //Exclude contracts that start after this month
        $contracts = Contract::where([
                ['owner_id',$owner_id],
                ['start_date','<=', $start_before],
                ['end_date','>=', $finish_after],
            ])
            ->with('payments','tenant','box', 'model')
            ->get();
        $payments =[];
        foreach ($contracts as $contract){
            $contract_payments = $contract->payments;
            foreach ($contract_payments as $payment){
                if ($month == date("m-Y",strtotime($payment->due_date))||$month == date("m-Y",strtotime("+1 month",strtotime($payment->due_date)))){
                    $payments[] = ['payment'=>$payment, 'contract'=>$contract];
                }

            }
        }
        return view('bill.list', 
            ['payments'=>$payments, 'owner_id'=>$owner_id, 'month'=>$month]
        );
    }

    /**
     * Update payment
     * 
     * Update payment's satuts by adding a payment date
     * @param int $payment_id  - payment to update
     * @return  (($to is null ? \Illuminate\Routing\Redirector : \Illuminate\Http\RedirectResponse))
     */
    public function update($payment_id){
        $payment = Payment::where('id', $payment_id)->with('contract.owner')->first();
        $payment->update(['payment_date'=>date('Y-m-d')]);
        return redirect()->route('payments.show', [$payment->contract->owner->id,date("m-Y",strtotime($payment->due_date))]);
    }

    public function download($file_name){
        return Storage::disk('public')->download($file_name);
    }

    public function export($month){
        $filename = "Paiements_$month.csv";
        $payment_file = fopen("php://output", "w");
        $content = "Nom;Prénom;Email;Téléphone;Adresse;Box; Montant; Dû le; Payé le;\n";
        $payments = Payment::where('payment_date', '!=', null)
            ->whereMonth('due_date',explode('-',$month)[0])
            ->whereYear('due_date',explode('-',$month)[1])
            ->with('contract.tenant','contract.box')
            ->get();
        foreach ($payments as $payment){
            if ($payment->contract->owner_id === Auth::user()->id){
                $content .= $payment->contract->tenant->last_name.";".$payment->contract->tenant->first_name.";".$payment->contract->tenant->email.";".$payment->contract->tenant->phone.";".str_replace("\n",'',$payment->contract->tenant->address).";".str_replace("\n",'',$payment->contract->box->address).";".$payment->contract->box->price."€;".$payment->due_date.";".$payment->payment_date.";\n";   
            }
        }
        fwrite($payment_file, $content);
        fclose($payment_file);
        $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");
    }
}
