<?php

namespace Pugofka\Yametrika;

class YametrikaClient
{
    protected $appId;

    public function __construct()
    {
        $this->appId = config('yametrika.app_id');
    }

    public function getAppid()
    {
        return $this->appId;
    }

}