<?php

namespace Cw;

use Slim\Slim;
use Cw\JsonPostRequestMiddleware;
use There4\Slim\Test\WebTestCase;

class JsonPostRequestMiddlewareTest extends WebTestCase
{

    /**
     * @inheritdoc
     */
    public function getSlimInstance()
    {
        $app = new Slim(array(
            'debug' => false,
        ));

        $app->add(new JsonPostRequestMiddleware());

        $app->post('/messages', function () use ($app) {
            $json = $app->post_json;
            echo 'message:' . $json['message'];
        });

        return $app;
    }

    public function testPostJson()
    {
        $this->client->post('/messages', array(), array(
            'slim.input'   => json_encode(array('message' => 'hogehoge')),
            'CONTENT_TYPE' => 'application/json'
        ));

        $this->assertSame('message:hogehoge', $this->client->response->getBody());
    }

    public function testPostJsonWithoutContentType()
    {
        $this->client->post('/messages', array(), array(
            'slim.input'   => json_encode(array('message' => 'hogehoge')),
        ));

        $this->assertSame('message:', $this->client->response->getBody());
    }
}
