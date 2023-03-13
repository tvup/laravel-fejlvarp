<?php

namespace Tvup\LaravelFejlVarp\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tvup\LaravelFejlVarp\LaravelFejlVarp
 */
class LaravelFejlVarp extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Tvup\LaravelFejlVarp\LaravelFejlVarp::class;
    }
}
