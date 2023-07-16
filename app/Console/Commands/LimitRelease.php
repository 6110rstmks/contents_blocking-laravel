<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Word;
use Auth;
use Log;
use App\Models\User;

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
        $user = User::where('id', 1)->first();
        $user->dayLimit = 0;
        $user->save();
        Log::debug('oiuoiuiuiu');
    }
}
