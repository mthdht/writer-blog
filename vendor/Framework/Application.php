<?php
/**
 * @author mthdht
 * @license MIT
 */

namespace Framework;

use Framework\Database\QueryBuilder;
use Framework\Routing\Router;
use Framework\Database\Manager;
use App\Models\CategoriesManager;

class Application
{
    public function run()
    {
        $data2 = CategoriesManager::create([
            'title' => 'title insert',
            'content' => 'content insert'
        ]);
        var_dump($data2);

        /*Router::get('/', function () {
            return 'hello';
        });
        // lance le router
        $response = Router::run();
        echo ($response);*/

    }
}