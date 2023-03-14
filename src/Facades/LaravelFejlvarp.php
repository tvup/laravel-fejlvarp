<?php

namespace Tvup\LaravelFejlvarp\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tvup\LaravelFejlvarp\LaravelFejlvarp
 */
class LaravelFejlvarp extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Tvup\LaravelFejlvarp\LaravelFejlvarp::class;
    }
}
