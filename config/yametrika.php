<?php

return [

    /**
     * The application ID
     * @doc https://yandex.ru/dev/oauth/doc/dg/tasks/register-client-docpage/
     * @link https://oauth.yandex.ru/client/new
     *
     */
    'app_id' => env('YMETRIKA_APP', 'test app'),

    /**
     * Auth token. Can be set statically from config or dynamically at runtime
     */
    'token' => env('YMETRIKA_TOKEN'),

    /**
     * Counter id. Can be set statically from config or dynamically at runtime
     */
    'counter_id' => env('YMETRIKA_COUNTER'),

];