<?php


namespace Pugofka\Yametrika;

use Carbon\Carbon;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

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
     * @param  int  $limit
     * @param  int  $offset
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
            'metrics'    => 'ym:s:visits,ym:s:pageviews,ym:s:users',
            'dimensions' => 'ym:s:date',
            'sort'       => 'ym:s:date',
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

        if($parent_id) {
            $urlParams['parent_id'] = '["'.$parent_id.'"]';
        }
        $url .= $this->convertUrlParamsToUriForDrilldown($urlParams);

        return $this->request([], $url);
    }

    /**
     * tags_u_t_m, drilldown, квартал, понедельно
     *
     * @param  Carbon  $dateFrom
     * @param  Carbon  $dateTo
     * @return array
     */
    public function getUTMReport(Carbon $dateFrom, Carbon $dateTo): array
    {
        return [];

    }

    /**
     * adv_engine, drilldown, квартал, понедельно
     *
     * @param  Carbon  $dateFrom
     * @param  Carbon  $dateTo
     * @return array
     */
    public function getADVEngineReport(Carbon $dateFrom, Carbon $dateTo): array
    {
        return [];

    }

    /**
     * tech_devices, data, квартал, итого
     *
     * @param  Carbon  $dateFrom
     * @param  Carbon  $dateTo
     * @return array
     */
    public function getDeviceReport(Carbon $dateFrom, Carbon $dateTo): array
    {
        return [];

    }



}