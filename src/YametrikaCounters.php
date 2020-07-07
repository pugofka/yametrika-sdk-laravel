<?php


namespace Pugofka\Yametrika;

use Illuminate\Support\Facades\Http;


class YametrikaCounters
{
    /** @var YametrikaClient */
    public $client;

    public function __construct(YametrikaClient $client)
    {
        if(!$client->isTokenExist()) {
            throw new \Exception('Yametrika token is empty');
        }

        $this->client = $client;
    }

    public function getCounters() :array
    {
        $response = Http::withHeaders([
            'Authorization' => 'OAuth '.$this->client->getToken(),
            'Content-Type' => 'application/json'
        ])->get('https://api-metrika.yandex.net/management/v1/counters?status=Active');

        if($response->status() === 401) {
            throw new \Exception($response->json()['message'] ?? 'Invalid token');
        }
        elseif($response->status() !== 200) {
            throw new \Exception($response->json()['message'] ?? 'Yandex error');
        }

        $data = collect($response->json()['counters']) ?? null;
        if(!$data) {
            return [];
        }

        // filter array
        return $data->map(function($counter) {
            return
                [
                    'id' => $counter['id'],
                    'site' => $counter['site']
                ];
        })->toArray();

    }

}