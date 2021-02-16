# Laravel SDK client to Yandex.Metrika service

This is not offical package.
Can work with static configuration for one project and with dynamically configuration at runtime for SAAS.

## Usage
1. Create new app [link](https://oauth.yandex.ru/client/new)
2. Set app_id to config
3. use getAuthTokenLink() for for auth link.
[Docs for work with Yandex Oauth](https://yandex.ru/dev/oauth/doc/dg/concepts/ya-oauth-intro-docpage/). Set token for static resource or use this example for set it for dinamyc resources:
```php
use Pugofka\Yametrika\YametrikaClient;

class AwesomeClass {
    
    public function setToken(YametrikaClient $client) 
    {
        $client->setToken('your_token');
    }
}
```

YametrikaClient class is singleton.

## Counters
YametrikaCounters class response for work with counters. getCounters() method return array of counters

## Reports

Before use Reports, you should set app_id, token and counter_id.

### Ecom report

Get data for ecom reports.
```php
$ecomReport = resolve(\Pugofka\Yametrika\YametrikaEcomReports::class);
$ecomData = $ecomReport->getEcomData(\Carbon\Carbon::today()->subYears(1), \Carbon\Carbon::today(), $limit = 500, $offset = 1);
$ecomSources = $ecomReport->getEcomSourcesReport(\Carbon\Carbon::today()->subWeek(), \Carbon\Carbon::today(), $limit = 500, $offset = 1);
```



