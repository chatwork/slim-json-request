<?php

namespace Cw;

use Slim\Middleware;

class JsonPostRequestMiddleware extends Middleware
{
    public function call()
    {
        $app = $this->app;

        $app->hook('slim.before.router', function () use ($app) {
            $post = $app->request->getBody();
            if ($app->request->getMediaType() == 'application/json' && !empty($post)) {
                $params = json_decode($post, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    $err_msg = sprintf('Post body is not json format: %s', $post);
                    throw new \UnexpectedValueException($err_msg);
                }

                $app->post_json = $params;
            }
        });

        $this->next->call();
    }
}
