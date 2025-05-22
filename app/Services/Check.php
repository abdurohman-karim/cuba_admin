<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class Check
{
    static function forbiddenAccess():void
    {
        header('HTTP/1.1 403 Forbidden');
        die();
    }

    static function permission($permission):void
    {
        if (!auth()->user()->hasPermission($permission))
            self::forbiddenAccess();
    }
}
