<?php 
namespace App\Providers;

use Pimple\Container;
use Noodlehaus\Config;

class ConfigProvider
{
    public function register(Container $pimple)
    {
        return function ($c){
            return function($file) use ($c){
                return new Config($c['cfgPath'] . '/' . $file . '.json');
            };
        };
    }
}