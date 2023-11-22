<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\YoutubeChannel;

class InsertYoutubeDotCom extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:youtube-dot-com';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $channel = new YoutubeChannel;
        $channel->name = 'youtube.com';
        $channel->save();
    }
}
