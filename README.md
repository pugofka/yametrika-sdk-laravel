# Laravel SDK client to Yandex.Metrika service

This is not offical package.

## Usage
1. Create new app [link](https://oauth.yandex.ru/client/new)
2. Set app_id to config
3. Set token for static resource or use this example for set it for dinamyc resources:
```php
use Pugofka\Yametrika\YametrikaClient;

function (YametrikaClient $client) {
    $client->setToken('test_token');
}
```


