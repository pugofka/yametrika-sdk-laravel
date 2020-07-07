<?php

namespace Pugofka\Yametrika;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Pugofka\Yametrika\YametrikaClient
 */
class YametrikaFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'yametrika';
    }

}