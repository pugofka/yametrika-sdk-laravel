<?php

namespace Pugofka\Yametrika\Test;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
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

    /** @test */
    public function it_return_exception_if_non_auth()
    {
        $this->expectException(\Exception::class);
        $this->yametrikaClient->setToken('test');
        $this->yametrikaClient->setCounterId(123);
        $reports = new YametrikaReports($this->yametrikaClient);

        Http::fake([
            'api-metrika.yandex.net/*' => Http::response(['counters' => ''], 401)
        ]);

        $reports->getTrafficReport(Carbon::yesterday(), Carbon::today());
    }

    /** @test */
    public function it_return_data_for_correct_responce()
    {
        $this->yametrikaClient->setToken('test');
        $this->yametrikaClient->setCounterId(123);
        $reports = new YametrikaReports($this->yametrikaClient);

        Http::fake([
            'api-metrika.yandex.net/*' => Http::response(['data' => ''], 200)
        ]);

        $res = $reports->getTrafficReport(Carbon::yesterday(), Carbon::today());
        $this->assertEquals(['data' => ''], $res);
    }

    /** @test */
    public function it_correctly_return_url_by_type_request_data()
    {
        $this->yametrikaClient->setToken('test');
        $this->yametrikaClient->setCounterId(123);
        $reports = new YametrikaReports($this->yametrikaClient);
        $reportBase = self::getMethod('getUrlByType');

        $this->assertEquals('', $reportBase->invokeArgs($reports, ['']));
        $this->assertEquals('', $reportBase->invokeArgs($reports, ['data']));
        $this->assertEquals('/drilldown', $reportBase->invokeArgs($reports, ['drilldown']));
        $this->assertEquals('/bytime', $reportBase->invokeArgs($reports, ['time']));
        $this->assertEquals('/pivot', $reportBase->invokeArgs($reports, ['pivot']));
        $this->assertEquals('/pivot/drilldown', $reportBase->invokeArgs($reports, ['pivot-drilldown']));
        $this->assertEquals('/comparison', $reportBase->invokeArgs($reports, ['comparison']));
        $this->assertEquals('/comparison/drilldown', $reportBase->invokeArgs($reports, ['comparison-drilldown']));
        $this->assertEquals('', $reportBase->invokeArgs($reports, ['test_empty']));
    }

    /** @test */
    public function it_correctly_transform_url_params_to_query()
    {
        $this->yametrikaClient->setToken('test');
        $this->yametrikaClient->setCounterId(123);
        $reports = new YametrikaReports($this->yametrikaClient);
        $reportBase = self::getMethod('convertUrlParamsToUriForDrilldown');

        $this->assertEquals('?', $reportBase->invokeArgs($reports, [[]]));
        $this->assertEquals('?key1=val1&', $reportBase->invokeArgs($reports, [['key1' => 'val1']]));
        $this->assertEquals('?key1=val1&key2=val2&', $reportBase->invokeArgs($reports, [['key1' => 'val1', 'key2' => 'val2']]));

    }

    protected static function getMethod($name) {
        $class = new \ReflectionClass(YametrikaReports::class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }

}