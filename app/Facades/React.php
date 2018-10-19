<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class React
 * @package App\Facades
 */
class React extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'React';
    }

}