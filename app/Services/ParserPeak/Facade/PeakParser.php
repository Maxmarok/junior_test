<?php
/*
 * Copyright (c) YukiDub. Author: Daniil <den4ic2001@gmail.com>.
 *
 * 14.1.2022
 */

namespace App\Services\ParserPeak\Facade;

use Illuminate\Support\Facades\Facade;

class PeakParser extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'PeakParser';
    }
}
