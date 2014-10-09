slim-json-request
======================

[Slim](https://github.com/codeguy/Slim) middleware for supporting post json

## Installation

Using composer.

```json
    {
        "require": {
            "slim/slim": "2.4.*",
            "chatwork/slim-json-request": "dev-master"
        }
    }
```


## Usage

Add `Chatwork\JsonRequestMiddleware` in your `Slim` application.

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use Slim\Slim;
use Chatwork\JsonRequestMiddleware;

$app = new Slim(array(
  'debug' => true,
));

$app->add(new JsonRequestMiddleware());

$app->post('/messages', function() use ($app) {
    // Set json data to `$app->json_body` as array.
    echo $app->json_body['msg'];
});

$app->run();
```

Execute http request:

```
[cw-tanaka@macbook] % curl -H'Content-Type: application/json' http://localhost:9876/messages -X POST -d '{
"msg": "hogehoge"
}'
hogehoge
```

See [Testcase](https://github.com/chatwork/slim-json-request/blob/master/tests/JsonRequestMiddlewareTest.php).

## LICENSE

MIT
