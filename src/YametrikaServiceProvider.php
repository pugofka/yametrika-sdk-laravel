<?php

namespace Pugofka\Yametrika;

use Illuminate\Support\ServiceProvider;

/**
 * Class YametrikaServiceProvider
 * @package Pugofka\Yametrika
 */
class YametrikaServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/yametrika.php' => config_path('yametrika.php'),
            ], 'config');
        }

        $this->app->singleton(\Pugofka\Yametrika\YametrikaClient::class);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/yametrika.php', 'yametrika');
    }

}