<?php


namespace Pugofka\Yametrika;

use Carbon\Carbon;
use Illuminate\Http\Client\RequestException;

/**
 * Class YametrikaEcomReports
 * @package Pugofka\Yametrika
 */
class YametrikaReports extends YametrikaReportBase
{

    /**
     * Get traffic report
     *
     * @param  Carbon  $dateFrom
     * @param  Carbon  $dateTo
     * @return array
     * @throws RequestException
     */
    public function getTrafficReport(Carbon $dateFrom, Carbon $dateTo): array
    {
        $url = $this->getUrlByType('data');

        $urlParams = [
            'ids' => $this->client->getCounterId(),
            'date1' => $dateFrom->format('Y-m-d'),
            'date2' => $dateTo->format('Y-m-d'),
            'metrics' => 'ym:s:visits,ym:s:pageviews,ym:s:users',
            'dimensions' => 'ym:s:date',
            'sort' => 'ym:s:date',
            'group' => 'Day',
            'accuracy' => 'medium',
        ];

        return $this->request($urlParams, $url);
    }

    /**
     * Get source report
     *
     * @param  Carbon  $dateFrom
     * @param  Carbon  $dateTo
     * @param  string|null  $parent_id
     * @return array
     * @throws RequestException
     */
    public function getSourcesReport(Carbon $dateFrom, Carbon $dateTo, ?string $parent_id = null): array
    {
        $url = $this->getUrlByType('drilldown');

        $urlParams = [
            'ids' => $this->client->getCounterId(),
            'date1' => $dateFrom->format('Y-m-d'),
            'date2' => $dateTo->format('Y-m-d'),
            'preset' => 'sources_summary',
            'accuracy' => 'medium',
        ];

        if ($parent_id) {
            $urlParams['parent_id'] = '["'.$parent_id.'"]';
        }
        $url .= $this->convertUrlParamsToUriForDrilldown($urlParams);

        return $this->request([], $url);
    }

    /**
     *
     *
     * @param  Carbon  $dateFrom
     * @param  Carbon  $dateTo
     * @return array
     * @throws RequestException
     */
    public function getUTMReport(Carbon $dateFrom, Carbon $dateTo): array
    {
        // @todo drilldown works just for one level deep. Maybe to restructure flat data
        $url = $this->getUrlByType('data');

        $urlParams = [
            'ids' => $this->client->getCounterId(),
            'date1' => $dateFrom->format('Y-m-d'),
            'date2' => $dateTo->format('Y-m-d'),
            'preset' => 'tags_u_t_m',
            'accuracy' => 'medium',
        ];

        return $this->request($urlParams, $url);
    }

    /**
     * Adversting traffic report top 10
     *
     * @param  Carbon  $dateFrom
     * @param  Carbon  $dateTo
     * @return array
     */
    public function getADVEngineReport(Carbon $dateFrom, Carbon $dateTo): array
    {
        $url = $this->getUrlByType('data');

        $urlParams = [
            'ids' => $this->client->getCounterId(),
            'date1' => $dateFrom->format('Y-m-d'),
            'date2' => $dateTo->format('Y-m-d'),
            'preset' => 'adv_engine',
            'limit' => 10,
            'accuracy' => 'medium',
        ];

        return $this->request($urlParams, $url);
    }

    /**
     * Report by device type
     *
     * @param  Carbon  $dateFrom
     * @param  Carbon  $dateTo
     * @return array
     */
    public function getDeviceReport(Carbon $dateFrom, Carbon $dateTo): array
    {
        $url = $this->getUrlByType('data');

        $urlParams = [
            'ids' => $this->client->getCounterId(),
            'date1' => $dateFrom->format('Y-m-d'),
            'date2' => $dateTo->format('Y-m-d'),
            'metrics' => 'ym:s:visits,ym:s:users',
            'dimensions' => 'ym:s:deviceCategory',
            'sort' => '-ym:s:visits',
            'accuracy' => 'medium',
        ];

        return $this->request($urlParams, $url);
    }

}