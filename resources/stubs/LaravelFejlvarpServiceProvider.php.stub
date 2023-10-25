<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LaravelFejlvarpServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            \Illuminate\Contracts\Debug\ExceptionHandler::class,
            \Tvup\LaravelFejlvarp\Exceptions\LaravelFejlvarpExceptionHandler::class
        );
    }
}