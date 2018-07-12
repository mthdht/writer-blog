<?php
/**
 * @author mthdht
 * @license MIT
 */

namespace Framework;

use Framework\Config\Config;
use Framework\Http\Response;
use Framework\Routing\Router;
use Framework\Http\Request;

class Application
{
    public $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    public function run()
    {
        require Config::get('routes');

        Router::get('/{id}', 'testController@index');

        $response = Response::create(Router::run($this->request));
        $response->send();

    }
}