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
        $urlParams = [
            'ids' => $this->client->getCounterId(),
            'date1' => $dateFrom->format('Y-m-d'),
            'date2' => $dateTo->format('Y-m-d'),
            'metrics' => 'ym:s:mobilePercentage, ym:s:visits, ym:s:ecommercePurchases, ym:s:ecommerceRUBRevenuePerVisit, ym:s:ecommerceRUBRevenuePerPurchase',
            'dimensions' => 'ym:s:purchaseID,ym:s:firstTrafficSource,ym:s:firstSourceEngine,ym:s:lastsignTrafficSource,ym:s:lastsignSourceEngine',
            'sort' => 'ym:s:purchaseID',
            'preset' => 'purchase',
            'limit' => $limit,
            'offset' => $offset,
            'sampled' => false,
        ];

        return $this->request($urlParams, '/data');
    }

}