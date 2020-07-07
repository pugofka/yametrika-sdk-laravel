<?php

namespace Pugofka\Yametrika;

/**
 * Class YametrikaClient
 * @package Pugofka\Yametrika
 */
class YametrikaClient
{
    /**
     * Yandex Metrika application Id
     * @var string
     */
    protected $appId;

    /**
     * Auth token
     *
     * @var string
     */
    protected $token;

    public function __construct()
    {
        $this->appId = config('yametrika.app_id');
        $this->token = config('yametrika.token');
    }

    /**
     * return application id
     * @return string|null
     */
    public function getAppid(): ?string
    {
        return $this->appId;
    }

    /**
     * get url link for auth yandex app
     * @return string
     */
    public function getAuthTokenLink(): string
    {
        return 'https://oauth.yandex.ru/authorize?response_type=token&client_id='.$this->appId.'&force_confirm=yes';
    }

    /**
     * @param  string  $token
     */
    public function setToken(string $token)
    {
        $this->token = $token;
    }

    /**
     * @return string|null
     */
    public function getToken() :?string
    {
        return $this->token;
    }

    /**
     * check is set token
     * @return bool
     */
    public function isTokenExist(): bool
    {
        return (isset($this->token) && !empty($this->token));
    }

}