<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Log;

class DisableProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $word;

    /**
     * Create a new job instance.
     */
    public function __construct($word)
    {
        $this->word = $word;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // $user = User::where('id', 1)->first();
        $abc = $this->word;
        $abc->disableFlg = 0;
        Log::debug($abc->name);
        $abc->save();
    }
}
