<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaxesController extends Controller
{

    /**
     * Form to choose the system of taxes
     * @param int $user_id authenticated user's id 
     */
    public function show($user_id){
        $result = session('result');
        return view('tax.generate', ['result'=>$result]);
    }

    /**
     * Calculate infos for taxes
     * @param Request $request infos needed for the calcul
     */
    public function generate(Request $request){
        $system= $request->system;
        $year = Carbon::now()->year;
        $contracts = Contract::where('owner_id', $request->owner_id)
            ->whereYear('start_date', '<=', $year)
            ->whereYear('end_date', '>=', $year)
            ->with('box')
            ->get();
        $total_revenue = 0;

        // Determine how many month during the year the contract was effective
        foreach ($contracts as $contract){
            if (
                ($contract->start_date->year < $year && $contract->end_date->year > $year) ||
                ($contract->start_date->month === 1 && $contract->start_date->year === $year && $contract->end_date->year > $year) ||
                ($contract->end_date->month === 12 && $contract->end_date->year === $year && $contract->start_date->year < $year)
            ){ 
                // Case all month of the year are in contract
                $total_revenue += $contract->monthly_price *12;
            } else if ($contract->start_date->year === $year && $contract->end_date->year > $year) {
                $nb_month = 13 - $contract->start_date->month;
                $total_revenue += $contract->monthly_price *$nb_month;
            }else if ($contract->start_date->year < $year && $contract->end_date->year === $year) {
                $total_revenue += $contract->monthly_price *$contract->end_date->month;
            }else if ($contract->start_date->year === $year && $contract->end_date->year === $year) {
                $nb_month = $contract->end_date->month - $contract->start_date->month + 1;
                $total_revenue += $contract->monthly_price*$nb_month;
            }
        }
        $result = [];
        $result['sum_to_inform'] = $total_revenue;
        if ($total_revenue >= 15000 && $system === 'property'){
            $result['message'] = 'Vos revenus sont trop élevés pour être imposé au régime micro-foncier. Passage au régime réel';
            $system = 'real';
        }
        if ($system === 'property') {
            $result['case'] = 'case 4 BE de la déclaration n°2042';
            $result['sum_taxed'] = $total_revenue*0.7;
            $result['system'] = 'Régime micro-foncier';
        } else {
            $result['case'] = 'case 4 BA de la déclaration n°2044';
            $result['sum_taxed'] = $total_revenue;
            $result['system'] = 'Régime réel';
        }
        $result['taxes'] = $result['sum_taxed']*0.06;

        return redirect()->route('taxes.show', [$request->owner_id])->with('result',$result);
    }

    /**
     * Export calcul result to pdf
     * @param Request $requets calcul's results
     */
    public function export(Request $request){
        $year = Carbon::now()->year;
        $data = [
            'title' => "Impôts_$year",
            'info' =>json_decode($request->result,true)
        ];
        $pdf = Pdf::loadView('tax.pdf.tax', $data);
        return $pdf->download("Impôts_$year.pdf");
    }
}
