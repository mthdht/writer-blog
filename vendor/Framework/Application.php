<?php
/**
 * @author mthdht
 * @license MIT
 */

namespace Framework;

use Framework\Database\QueryBuilder;
use Framework\Routing\Router;

class Application
{
    public function run()
    {
        $query = QueryBuilder::table('user')->select('id', 'titre')->where('id', '=', 1)->where('titre', '=', 'test');
        var_dump($query);
        //Router::get('/', 'homeController@index');
        Router::get('/', function () {
            return 'hello';
        });
        // lance le router
        $response = Router::run();
        echo ($response);

    }
}