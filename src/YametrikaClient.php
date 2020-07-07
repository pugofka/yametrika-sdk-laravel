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

    /**
     * Selected counter ID
     *
     * @var int
     */
    protected $counterId;

    public function __construct()
    {
        $this->appId = config('yametrika.app_id');
        $this->token = config('yametrika.token');
        $this->counterId = config('yametrika.counter_id') ? (int) config('yametrika.counter_id') : null;
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
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param  string  $token
     */
    public function setToken(string $token)
    {
        $this->token = $token;
    }

    /**
     * @return int|null
     */
    public function getCounterId(): ?int
    {
        return $this->counterId;
    }

    /**
     * @param  int  $counterId
     */
    public function setCounterId(int $counterId): void
    {
        $this->counterId = $counterId;
    }

    /**
     * check is set token
     * @return bool
     */
    public function isTokenExist(): bool
    {
        return (isset($this->token) && !empty($this->token));
    }

    /**
     * check is set token
     * @return bool
     */
    public function isCounterExist(): bool
    {
        return (bool) $this->counterId;
    }

}