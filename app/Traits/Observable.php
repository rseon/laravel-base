<?php

namespace App\Traits;

trait Observable
{
    public static function bootObservable()
    {
        if (isset(static::$observer)) {
            static::observe(static::$observer);
        }
    }
}
