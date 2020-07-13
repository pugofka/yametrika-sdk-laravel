<?php


namespace Pugofka\Yametrika;

use Exception;
use Illuminate\Support\Facades\Http;

/**
 * Class YametrikaCounters
 * @package Pugofka\Yametrika
 */
class YametrikaCounters
{
    /** @var YametrikaClient */
    public $client;

    /**
     * YametrikaCounters constructor.
     * @param  YametrikaClient  $client
     * @throws Exception
     */
    public function __construct(YametrikaClient $client)
    {
        if (!$client->isTokenExist()) {
            throw new Exception('Yametrika token is empty');
        }

        $this->client = $client;
    }

    /**
     * Get all active available counters
     *
     * @return array
     * @throws Exception
     */
    public function getCounters(): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'OAuth '.$this->client->getToken(),
            'Content-Type' => 'application/json'
        ])->get('https://api-metrika.yandex.net/management/v1/counters?status=Active');

        if ($response->status() === 401) {
            throw new Exception(array_key_exists('message', $response->json()) ? $response->json()['message'] : 'Invalid token');
        } elseif ($response->status() !== 200) {
            throw new Exception(array_key_exists('message', $response->json()) ? $response->json()['message'] : 'Yandex error');
        }

        $data = array_key_exists('counters', $response->json()) ? collect($response->json()['counters']) ?? null : null;
        if (!$data) {
            return [];
        }

        // filter array
        return $data->map(function ($counter) {
            return
                [
                    'id' => $counter['id'],
                    'site' => $counter['site']
                ];
        })->toArray();
    }

}