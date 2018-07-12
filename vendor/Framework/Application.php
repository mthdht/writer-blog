<?php
/**
 * @author mthdht
 * @license MIT
 */

namespace Framework;

use Framework\Http\Response;
use Framework\View\View;
use Framework\Http\Request;

class Application
{
    public $request;

    public $response;

    public $config;

    public function __construct()
    {
        $this->request = new Request();
    }

    public function run()
    {
        $response = Response::create(View::make('test.index')->render())
            ->header('test');
        $response->send();

    }
}