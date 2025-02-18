<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Payment;
use App\Services\BillService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Create a new bill and generate it's pdf
     * @param array $request data of the new bill
     */
    public static function store(array $request){
        $month = date('m-Y', strtotime($request['month']));
        $billService = new BillService();
        try {
            $billService->store($request);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
        return redirect()->route('bills.show',[$request['owner_id'], $month]);
    }

    /**
     * List all due payment by month
     * @param int $owner_id autheticad user's id
     * @param string $month wanted month
     */
    public function show($owner_id,$month){
        $billService = new BillService();
        try {
            $payments = $billService->show($owner_id,$month);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
        return view('payment.list', 
            ['payments'=>$payments, 'owner_id'=>$owner_id, 'month'=>$month]
        );
    }

    /**
     * Show bills per month
     * @param int $owner_id autheticad user's id
     * @param string $month wanted month
     */
    public function showBills($owner_id,$month){
        $billService = new BillService();
        try {
            $result = $billService->showBills($owner_id,$month);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
        return view('bill.list', 
            ['payments'=>$result[0],'contracts'=>$result[1], 'owner_id'=>$owner_id, 'month'=>$month]
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
        $billService = new BillService();
        try {
            $payment = $billService->update($payment_id);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
        return redirect()->route('payments.show', [$payment->contract->owner->id,date("m-Y",strtotime($payment->due_date))]);
    }

    /**
     * Delete a bill
     * @param int $id deleted bill' id
     * @param int $owner_id autheticad user's id
     * @param string $month wanted month shown after delete
     */
    public function destroy($id, $owner_id, $month) {
        $billService = new BillService();
        try {
            $billService->destroy($id);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
        return redirect()->route('bills.show',[$owner_id, $month]);
        
    }

    /**
     * Download bill
     * @param string $file_name file to download
     */
    public function download($file_name){
        $billService = new BillService();
        try {
            return $billService->download($file_name);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    /**
     * Export all payments of the month
     * @param string $month month wanted
     */
    public function export($month){
        $billService = new BillService();
        try {
            $billService->export($month);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }
}
