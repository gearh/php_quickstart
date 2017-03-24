<?php 
namespace App\Providers;

use Pimple\Container;
use Gearh\Route\Router;
use Gearh\Route\Rule;

class RouteProvider
{
    public function register(Container $pimple)
    {
        return function (){
            $route = new Router;
            $this->_extend($route);

            return $route;
        };
    }

    private function _extend($route){

        $route->setProcClosure(function ($string){
            list($type, $class, $funName) = explode('.', $string);
            $typeList = [
                'con' => 'Controller',
                'mid' => 'Middleware',
            ];

            $class = 'App\\' . $typeList[$type] . 's\\' . lcfirst($class) . $typeList[$type];
            $object = new $class();

            return function () use ($object, $funName){
                return call_user_func_array([$object, $funName], func_get_args());
            };
        });

    }
}