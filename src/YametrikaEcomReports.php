<?php


namespace Pugofka\Yametrika;

use Carbon\Carbon;
use Illuminate\Http\Client\RequestException;

/**
 * Class YametrikaEcomReports
 * @package Pugofka\Yametrika
 */
class YametrikaEcomReports extends YametrikaReportBase
{

    /**
     * @param  Carbon  $dateFrom
     * @param  Carbon  $dateTo
     * @param  int  $limit
     * @param  int  $offset
     * @return array
     * @throws RequestException
     */
    public function getEcomData(Carbon $dateFrom, Carbon $dateTo, $limit = 500, $offset = 1): array
    {
        $url = $this->getUrlByType('data');

        $urlParams = [
            'ids' => $this->client->getCounterId(),
            'date1' => $dateFrom->format('Y-m-d'),
            'date2' => $dateTo->format('Y-m-d'),
            'metrics' => 'ym:s:mobilePercentage, ym:s:visits, ym:s:ecommercePurchases, ym:s:ecommerceRUBRevenuePerVisit, ym:s:ecommerceRUBRevenuePerPurchase',
            'dimensions' => 'ym:s:purchaseID,ym:s:firstTrafficSource,ym:s:firstSourceEngine,ym:s:lastsignTrafficSource,ym:s:lastsignSourceEngine',
            'sort' => 'ym:s:purchaseID',
            'group' => 'Day',
            'preset' => 'purchase',
            'limit' => $limit,
            'offset' => $offset,
            'accuracy' => 'full',
        ];

        return $this->request($urlParams, $url);
    }

    /**
     * @param  Carbon  $dateFrom
     * @param  Carbon  $dateTo
     * @param  int  $limit
     * @param  int  $offset
     * @return array
     * @throws RequestException
     */
    public function getPurchaseEcomData(Carbon $dateFrom, Carbon $dateTo, $limit = 500, $offset = 1): array
    {
        $url = $this->getUrlByType('time');

        $urlParams = [
            'ids' => $this->client->getCounterId(),
            'date1' => $dateFrom->format('Y-m-d'),
            'date2' => $dateTo->format('Y-m-d'),
            'metrics' => 'ym:s:ecommercePurchases',
            'dimensions' => 'ym:s:lastSourceEngine',
            'group' => 'day',
            'sort' => 'ym:s:ecommercePurchases',
            'preset' => 'purchase',
            'limit' => $limit,
            'offset' => $offset,
            'accuracy' => 'full',
            'top_keys' => 10
        ];

        return $this->request($urlParams, $url);
    }

    /**
     * Api method for work with raw queries to Yandex
     *
     * @param  array  $data
     * @param  string  $urlPostfix
     * @return array
     * @throws RequestException
     */
    public function getRawReportData(array $data = [], string $urlPostfix = ''): array
    {
        return $this->request($data, $urlPostfix);
    }

}