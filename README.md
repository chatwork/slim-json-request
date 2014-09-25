slim-post-json-request
======================

[Slim](https://github.com/codeguy/Slim) middleware for supporting post json

## Installation

Using composer. 

```json
    {
        "require": {
            "slim/slim": "2.4.*",
            "chatwork/slim-post-json-request": "dev-master"
        }
    }
```


## Usage

Add `Chatwork\JsonPostRequestMiddleware` in your `Slim` application.

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use Slim\Slim;
use Chatwork\JsonPostRequestMiddleware;

$app = new Slim(array(
  'debug' => true,
));

$app->add(new JsonPostRequestMiddleware());

$app->post('/messages', function() use ($app) {
    // Set json data to `$app->post_json` as array.
    echo $app->post_json['body'];
});

$app->run();
```

Execute http request:

```
[cw-tanaka@macbook] % curl -H'Content-Type: application/json' http://localhost:9876/messages -X POST -d '{
"body": "hogehoge"
}'
hogehoge
```

See [Testcase](https://github.com/chatwork/slim-post-json-request/blob/master/tests/JsonPostRequestMiddlewareTest.php).

## LICENSE

MIT
