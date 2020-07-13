<?php

namespace Pugofka\Yametrika\Test;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Pugofka\Yametrika\YametrikaClient;
use Pugofka\Yametrika\YametrikaCounters;
use Pugofka\Yametrika\YametrikaReportBase;
use Pugofka\Yametrika\YametrikaReports;

/**
 * Class YametrikaCountersTest
 * @package Pugofka\Yametrika\Test
 */
class YametrikaCountersTest extends TestCase
{
    /** @var YametrikaClient */
    protected $yametrikaClient;

    protected $yametrikaCounters;

    public function setUp(): void
    {
        parent::setUp();

        $this->yametrikaClient = new YametrikaClient();
        $this->yametrikaClient->setToken('test');
        $this->yametrikaClient->setCounterId(123);

        $this->yametrikaCounters = new YametrikaCounters($this->yametrikaClient);
    }

    /** @test */
    public function it_return_exception_if_non_auth()
    {
        $this->expectException(\Exception::class);

        Http::fake([
           'api-metrika.yandex.net/*' => Http::response(['counters' => ''], 401)
        ]);
        $this->yametrikaCounters->getCounters();
    }

    /** @test */
    public function it_return_exception_if_yandex_return_error()
    {
        $this->expectException(\Exception::class);

        Http::fake([
            'api-metrika.yandex.net/*' => Http::response(['counters' => ''], 500)
        ]);
        $this->yametrikaCounters->getCounters();
    }

    /** @test */
    public function it_return_empty_array_if_counters_not_available()
    {
        Http::fake([
            'api-metrika.yandex.net/*' => Http::response([], 200)
        ]);
        $res = $this->yametrikaCounters->getCounters();
        $this->assertEquals([], $res);
    }

    /** @test */
    public function it_return_array_counters()
    {
        Http::fake([
            'api-metrika.yandex.net/*' => Http::response(['counters' =>
                [
                    [
                        'id' =>  '1',
                        'site' => 'www.site.ru',
                        'add_param' => 'test_param'
                    ],
                    [
                        'id' =>  '2',
                        'site' => 'site.com',
                    ],
                ],
            ], 200)
        ]);
        $res = $this->yametrikaCounters->getCounters();;
        $this->assertEquals([
            [
                'id' =>  '1',
                'site' => 'www.site.ru',
            ],
            [
                'id' =>  '2',
                'site' => 'site.com',
            ],
        ], $res);
    }

}