<?php
namespace App\Middlewares;

class HttpMiddleware
{
    public function index($next, $app)
    {
        # befor
        # 过滤注入信息

        # next
        $response = $next($app);

        # after
        if (!($response instanceof Response)) {
            if (is_string($response)) {
                $app['response']->getBody()->write($response);
            }

            $response = $app['response'];
        }
        
        return $response;
    }
}