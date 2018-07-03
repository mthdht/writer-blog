<?php
/**
 * @author mthdht
 * @license MIT
 */

namespace Framework;

use Framework\Routing\Router;

class Application
{
    public function run()
    {
        //Router::get('/', 'homeController@index');
        Router::get('/test/{id}', 'TestController@show');
        // lance le router
        Router::run();

    }
}