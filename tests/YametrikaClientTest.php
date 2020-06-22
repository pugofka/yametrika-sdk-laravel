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
    }

}