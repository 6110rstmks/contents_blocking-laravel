<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Word;
use Auth;

class LimitRelease extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'limit:daily';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lifting restrictions on disable wordBlocking';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Auth::user()->update('dayLimit', 0);
    }
}
