<?php

namespace App\Imports;

use App\Models\YoutubeChannel;
use Maatwebsite\Excel\Concerns\ToModel;

class YoutubeChannelsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new YoutubeChannel([
            'name'     => $row[0],
        ]);
    }
}
