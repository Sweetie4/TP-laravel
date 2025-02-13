<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Payment;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public static function store($contract_id){
        $contract = Contract::find($contract_id);
        $start_date = $contract->start_date; 
        $end_date = $contract->end_date; 
        $interval = $start_date->diff($end_date);
        $nb_month = $interval->y * 12 + $interval->m;

        for ($i = 1; $i<$nb_month+1; $i++){
            if (!$start_date instanceof \Carbon\Carbon) {
                $start_date = \Carbon\Carbon::parse($start_date);
            }
            $start_date->addMonth();
            Payment::create([
                'contract_id' => $contract_id,
                'due_date' => $start_date->toDateString()
            ]);
            
        }
    }

    public function show($owner_id,$month){
        $first_date = date("Y-m-01 00:00:00", strtotime(DateTime::createFromFormat("m-Y", $month)->format('Y-m-d')));
        $last_date = date("Y-m-t 00:00:00", strtotime(DateTime::createFromFormat("m-Y", $month)->format('Y-m-d')));
        $contracts = Contract::where([
                ['owner_id',$owner_id],
                ['start_date','<=', $last_date],
                ['end_date','>=', $first_date],
            ])
            ->with('payments','tenant','box', 'model')
            ->get();
        $payments =[];
        foreach ($contracts as $contract){
            $contract_payments = $contract->payments;
            foreach ($contract_payments as $payment){
                if ($month == date("m-Y",strtotime($payment->due_date))){
                    $payments[] = ['payment'=>$payment, 'contract'=>$contract];
                }

            }
        }
        return view('payment.list', 
            ['payments'=>$payments, 'owner_id'=>$owner_id, 'month'=>$month]
        );
    }

    public function update($payment_id){
        $payment = Payment::where('id', $payment_id)->with('contract.owner')->first();
        $payment->update(['payment_date'=>date('Y-m-d')]);
        return redirect()->route('payments.show', [$payment->contract->owner->id,date("m-Y",strtotime($payment->due_date))]);
    }
}
