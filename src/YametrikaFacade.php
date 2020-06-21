<?php

namespace Pugofka\Yametrika;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Pugofka\Yametrika\Yametrika
 */
class YametrikaFacade
{
    protected static function getFacadeAccessor()
    {
        return 'yametrika';
    }

}