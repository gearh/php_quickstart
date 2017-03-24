<?php
namespace App\Controllers;

class DefaultController 
{
    public function notFound($app)
    {
        $app['response'] = $app['response']->withStatus(404);
        $app['response']->getBody()->write('Not Found');

        return $app['response'];
    }

    public function home($app)
    {
        return $app['view']->render('home', [
            'name' => 'name',
        ]);
    }
}