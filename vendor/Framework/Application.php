<?php
/**
 * @author mthdht
 * @license MIT
 */

namespace Framework;

use Framework\Database\QueryBuilder;
use Framework\Routing\Router;
use Framework\Database\Manager;
use Framework\View\View;

class Application
{
    public function run()
    {
        $view = View::make('test.index', [
            'title' => 'test complet',
            'content' => 'avec layout et section'
        ]);
        $page = $view->render();
        echo $page;

        /*$view2 = View::make('test.wihoutExtend', [
            'title' => 'test sans extend',
            'content' => 'sans extend juste la vue'
        ]);*/

    }
}