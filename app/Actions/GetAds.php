<?php

namespace App\Actions;

use App\Models\Ad;
use App\Models\Branch;

class GetAds
{
    public function __invoke()
    {
        $ads=Ad::all();
        $branches=Branch::all();
        return view('home' ,['ads'=>$ads,'branches'=>$branches]);

    }
}
