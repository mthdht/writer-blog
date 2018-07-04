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
        Router::get('/test/{id}/test2/{id2}', 'TestController@show')->where('id', '[a-z]+');
        // lance le router
        $response = Router::run();
        echo ($response);

    }
}