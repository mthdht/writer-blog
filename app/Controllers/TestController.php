<?php
/**
 * Created by PhpStorm.
 * User: mthdht
 * Date: 12/07/18
 * Time: 16:02
 */

namespace App\Controllers;


use Framework\Http\Request;
use Framework\View\View;

class TestController
{
    public function index($id)
    {
        $view = View::make('test.index', [
            'title' => 'titre de test' . $id,
            'content' => 'content de test'
        ]);
        return $view->render();
    }


}