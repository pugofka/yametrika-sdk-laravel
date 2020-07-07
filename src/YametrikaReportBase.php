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

    private $baseUrl = 'https://api-metrika.yandex.net/stat/v1';

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
        ])->get($this->baseUrl.$url, $params);

        if ($response->failed()) {
            throw new Exception($response->json()['message'] ?? 'HTTP request returned status code '.$response->status());
        }

        return $response->json();
    }
}