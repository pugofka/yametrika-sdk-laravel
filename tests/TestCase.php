<?php


namespace Pugofka\Yametrika\Test;

use Orchestra\Testbench\TestCase as Orchestra;
use Pugofka\Yametrika\YametrikaServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            YametrikaServiceProvider::class,
        ];
    }

}