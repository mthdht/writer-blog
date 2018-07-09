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
            'title' => 'mon titre de blog',
            'content' => 'contenu de blog'
        ]);

        $view->render();
    }
}