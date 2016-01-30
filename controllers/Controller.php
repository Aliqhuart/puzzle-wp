<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;
    
    protected  $data = [];
    
    public static function action ($method, $parameters = [], $absolute = true) {
        return action(static::actionString($method), $parameters, $absolute);
    }
    
    public static function actionString ($method) {
        return (static::class . '@' . $method);
    }
}
