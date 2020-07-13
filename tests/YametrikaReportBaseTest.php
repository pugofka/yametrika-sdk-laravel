<?php

namespace Pugofka\Yametrika\Test;

use Pugofka\Yametrika\YametrikaClient;
use Pugofka\Yametrika\YametrikaReportBase;
use Pugofka\Yametrika\YametrikaReports;

/**
 * Class YametrikaReportBaseTest
 * @package Pugofka\Yametrika\Test
 */
class YametrikaReportBaseTest extends TestCase
{
    /** @var YametrikaClient */
    protected $yametrikaClient;

    public function setUp(): void
    {
        parent::setUp();

        $this->yametrikaClient = new YametrikaClient();
    }

    /** @test */
    public function it_fails_if_token_not_set()
    {
        $this->expectException(\Exception::class);
        resolve(YametrikaReportBase::class);
    }

    /** @test */
    public function it_fails_if_counter_not_set()
    {
        $this->yametrikaClient->setToken('test');
        $this->expectException(\Exception::class);
        resolve(YametrikaReportBase::class);
    }

    /** @test */
    public function it_correctly_creates_if_all_params_setted()
    {
        $this->yametrikaClient->setToken('test');
        $this->yametrikaClient->setCounterId(123);
        new YametrikaReports($this->yametrikaClient);

        $this->assertTrue(true);
    }

}