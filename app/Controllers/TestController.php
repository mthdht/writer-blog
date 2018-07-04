<?php
/**
 * @author mthdht
 * @license MIT
 */

namespace App\Controllers;


class TestController
{

    public function show($id, $id2)
    {
        return 'je suis le test ' . $id . ', ' . $id2;
    }
}