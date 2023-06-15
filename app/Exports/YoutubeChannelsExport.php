<?php

namespace App\Exports;

use App\Models\YoutubeChannel;
use Maatwebsite\Excel\Concerns\FromCollection;

class YoutubeChannelsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        
        return YoutubeChannel::all();
    }
}
