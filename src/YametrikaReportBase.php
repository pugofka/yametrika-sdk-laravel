<?php


namespace Pugofka\Yametrika;


use Exception;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

/**
 * Abstract base class for reports
 *
 * Class YametrikaReportBase
 * @package Pugofka\Yametrika
 */
abstract class YametrikaReportBase
{
    /** @var YametrikaClient */
    public $client;

    private $baseUrl = 'https://api-metrika.yandex.net/stat/v1/data';

    public function __construct(YametrikaClient $client)
    {
        if (!$client->isTokenExist()) {
            throw new Exception('Yametrika token is empty');
        }

        if (!$client->isCounterExist()) {
            throw new Exception('Yametrika counter is not selected');
        }

        $this->client = $client;
    }

    /**
     * @param  array  $params
     * @param  string  $url
     * @return array
     * @throws RequestException
     */
    protected function request(array $params = [], $url = ''): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'OAuth '.$this->client->getToken(),
            'Content-Type' => 'application/x-yametrika+json',
        ])->get($this->baseUrl.$url, (count($params) > 0) ? $params : null);

        if ($response->failed()) {
            throw new Exception($response->json()['message'] ?? 'HTTP request returned status code '.$response->status());
        }

        return $response->json();
    }

    /**
     * Different types of response from Yandex
     *
     * @link https://yandex.ru/dev/metrika/doc/api2/api_v1/data-docpage/
     *
     * @param  string  $type
     * @return string
     */
    protected function getUrlByType(string $type): string
    {
        switch ($type) {
            case 'data':
                $url = '';
            break;
            case 'drilldown' :
                $url = '/drilldown';
            break;
            case 'time' :
                $url = '/bytime';
            break;
            case 'pivot' :
                $url = '/pivot';
            break;
            case 'pivot-drilldown' :
                $url = '/pivot/drilldown';
            break;
            case 'comparison' :
                $url = '/comparison';
            break;
            case 'comparison-drilldown' :
                $url = '/comparison/drilldown';
            break;

            default:
                $url = '';
            break;
        }

        return $url;

    }

    /**
     * Helper for convert Java list to Uri
     *
     * @param array  $urlParams
     * @return string
     */
    protected function convertUrlParamsToUriForDrilldown(array $urlParams): string
    {
        $url = '?';
        collect($urlParams)->each(function ($param, $key) use (&$url) {
            $url .= $key.'='. (string)$param.'&';
        });

        return $url;
    }
}