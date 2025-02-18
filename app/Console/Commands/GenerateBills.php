<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class GenerateBills extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bills:generate {month : month of the generated bills}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate all bills for filled month';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Artisan::call('queue:work --queue='.$this->argument('month').' --tries=5 --timeout=30') ;
        
    }
}
