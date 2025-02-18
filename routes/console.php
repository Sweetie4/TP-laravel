<?php

use App\Mail\Bills;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function (){
    $month = Carbon::now()->month;
    $payments= Payment::whereMonth('due_date', $month)->with('contract.tenant', 'contract.owner', 'contract.box')->get();
    foreach ($payments as $payment){
        if ($payment->contract){
            Mail::to($payment->contract->tenant->email)->send(new Bills($month,$payment->contract->owner, $payment->contract->tenant, $payment->contract->box, $payment));
        }
    }
})->monthlyOn(1, '8:00');

Schedule::command('queue:work --queue='.Carbon::now()->format('m/Y').' --tries=5 --timeout=30')->monthlyOn(1, '8:00');