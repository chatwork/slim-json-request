<?php

namespace Chatwork;

use Slim\Slim;
use Chatwork\JsonPostRequestMiddleware;
use There4\Slim\Test\WebTestCase;

class JsonPostRequestMiddlewareTest extends WebTestCase
{

    public function setUp()
    {
        $this->ob_level = ob_get_level();

        parent::setUp();
    }

    public function tearDown()
    {
        while(ob_get_level() > $this->ob_level) {
            echo ob_get_contents();
            ob_end_clean();
        }

        parent::tearDown();
    }

    /**
     * @inheritdoc
     */
    public function getSlimInstance()
    {
        $app = new Slim(array(
            'debug' => false,
        ));

        $app->add(new JsonPostRequestMiddleware());

        $app->post('/messages', function() use ($app) {
            $json = $app->post_json;
            $app->response->setBody('message:' . $json['message']);
        });

        $app->error(function(\UnexpectedValueException $e) use ($app) {
            $app->response->setBody('error:' . $e->getMessage());
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

    public function testPostNotJsonFormatString()
    {
        $this->client->post('/messages', array(), array(
            'slim.input'   => 'This is not json format',
            'CONTENT_TYPE' => 'application/json'
        ));
        $this->assertContains('error:', $this->client->response->getBody());
    }
}
