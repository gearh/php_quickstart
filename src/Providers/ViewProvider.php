<?php 
namespace App\Providers;

use Pimple\Container;
use League\Plates\Engine;

class ViewProvider
{
    public function register(Container $pimple)
    {
        return function ($c) {
            $path = $c['config']('main')->get('templates_path');
            $view = new Engine($path);

            $this->_share($view);
            $this->_extendRouteUrl($view, $c);

            return $view;
        };
    }

    protected function _share($view)
    {
        return $view->addData(['path' => []], 'layout');
    }

    protected function _extendRouteUrl($view, $pimple)
    {
        $route = $pimple['route'];
        $view->registerFunction('route', function ($name, $param = []) use ($route){
            return $route->url($name, $param);
        });
    }

}