<?php

namespace Chatwork;

use Slim\Middleware;
use Chatwork\Exception\InvalidJsonFormatException;

class JsonRequestMiddleware extends Middleware
{

    /**
     * Configuration.
     * 
     * @var array
     */
    private $config;

    /**
     * 
     * @param array Configuration.
     */
    public function __construct(array $config = array())
    {
        $default_config = array(

            // If you want to get json value as object, set `true`.
            // If this value is `false`, set json value as array.
            'json_as_object' => false,

        );

        $this->config = array_merge($default_config, $config);
    }

    public function call()
    {
        $app = $this->app;

        $app->hook('slim.before.router', function () use ($app) {
            $body = $app->request->getBody();
            if ($app->request->getMediaType() == 'application/json' && !empty($body)) {
                $params = json_decode($body, !$this->config['json_as_object']);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    $err_msg = sprintf('Post body is not json format: %s', $body);
                    throw new InvalidJsonFormatException($err_msg);
                }

                $app->json_body = $params;
            } else {
                $app->json_body = $this->config['json_as_object'] ? null : array();
            }
        });

        $this->next->call();
    }
}
