<?php 
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;
use Pimple\Container;
use Gearh\Route\Rule;

# server
{
    $app = new Container();
    $app['cfgPath'] = '../resources/config';
    $app['request'] = ServerRequestFactory::fromGlobals();
    $app['response'] = new Response();
    $app['view'] = (new App\Providers\ViewProvider)->register($app);
    $app['config'] = (new App\Providers\ConfigProvider)->register($app);
    $app['route'] = (new App\Providers\RouteProvider)->register($app);
}

# route
{
    $route = $app['route'];

    $route->addRoute('get', '', 'con.default.home', 'home');
  
    # 通配
    $route->add((new Rule)->from(':all', ['all' => '.'])->to(function ($app){
        return (new App\Controllers\DefaultController)->notFound($app);
    }));

    # 中间件
    $route->middleware('mid.http.index');
}
 
# trigger
{
    $request = $app['request'];
    $app['route']->run(
        $request->getUri()->getPath(), 
        $request->getMethod(), 
        function ($handle, $param) use ($app) {
            $app['param'] = $param;
            $response = $handle($app);
            return (new SapiEmitter)->emit($response);
        }
    );
}