<?php

namespace Chatwork;

use Slim\Middleware;
use Chatwork\Exception\InvalidJsonFormatException;

class JsonRequestMiddleware extends Middleware
{
    public function call()
    {
        $app = $this->app;

        $app->hook('slim.before.router', function () use ($app) {
            $body = $app->request->getBody();
            if ($app->request->getMediaType() == 'application/json' && !empty($body)) {
                $params = json_decode($body, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    $err_msg = sprintf('Post body is not json format: %s', $post);
                    throw new InvalidJsonFormatException($err_msg);
                }

                $app->json_body = $params;
            } else {
                $app->json_body = array();
            }
        });

        $this->next->call();
    }
}
