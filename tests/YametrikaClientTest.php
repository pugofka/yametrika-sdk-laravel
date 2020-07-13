<?php

namespace Pugofka\Yametrika\Test;

use Pugofka\Yametrika\YametrikaClient;

/**
 * Class YametrikaClientTest
 * @package Pugofka\Yametrika\Test
 */
class YametrikaClientTest extends TestCase
{
    /** @var YametrikaClient */
    protected $yametrikaClient;

    public function setUp(): void
    {
        parent::setUp();

        $this->yametrikaClient = new YametrikaClient();
    }

    /** @test */
    public function it_can_determine_exist_token()
    {
        $this->assertFalse($this->yametrikaClient->isTokenExist());
        $this->yametrikaClient->setToken('test token');
        $this->assertTrue($this->yametrikaClient->isTokenExist());
        $this->assertEquals('test token', $this->yametrikaClient->getToken());
    }

    /** @test */
    public function it_can_determine_exist_counter()
    {
        $this->assertFalse($this->yametrikaClient->isCounterExist());
        $this->yametrikaClient->setCounterId('123456');
        $this->assertTrue($this->yametrikaClient->isCounterExist());
        $this->assertEquals('123456', $this->yametrikaClient->getCounterId());
    }

    /** @test */
    public function it_return_auth_url_with_valid_app_id()
    {
        $queryUrl = parse_url($this->yametrikaClient->getAuthTokenLink(), PHP_URL_QUERY);
        parse_str($queryUrl, $queryParams);
        $this->assertEquals('test app', $queryParams['client_id']);
        $this->assertEquals($this->yametrikaClient->getAppid(), $queryParams['client_id']);
    }

}