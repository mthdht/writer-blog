<?php
/**
 * @author mthdht
 * @license MIT
 */

namespace App\Controllers;


class TestController
{

    public function show($id)
    {
        echo 'je suis le test ' . $id;
    }
}