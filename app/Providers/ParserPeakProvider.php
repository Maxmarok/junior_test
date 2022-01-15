<?php

namespace App\Providers;

use App\Services\ParserPeak\Parser;
use Illuminate\Support\ServiceProvider;

class ParserPeakProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('PeakParser', 'App\Services\ParserPeak\Parser');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
