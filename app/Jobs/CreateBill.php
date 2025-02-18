<?php

namespace App\Jobs;

use App\Http\Controllers\PaymentController;
use App\Models\Payment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CreateBill implements ShouldQueue
{
    use Queueable;


    protected $data;
    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        PaymentController::store($this->data);
    }
}
