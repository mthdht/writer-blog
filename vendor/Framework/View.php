<?php
/**
 * Created by PhpStorm.
 * User: mthdht
 * Date: 09/07/18
 * Time: 11:17
 */

namespace Framework;


class View
{
    protected $contentFile;
    protected $basePath;
    protected $data;

    public function __construct()
    {
        $this->basePath = ROOT . '/ressources/';
    }

    protected function make($content, $data = [])
    {
        $this->contentFile = $this->basePath . preg_replace('#\.#', '/', $content) . '.php';
        $this->data = $data;
        return $this;
    }

    public function render()
    {

        foreach ($this->data as $key => $value) {
            ${$key} = $value;
        }

        ob_start();
        require $this->contentFile;
        $content = ob_get_clean();

        ob_start();
        require $this->basePath . '/layouts/' . 'app.php';
        return ob_get_contents();
    }

    public static function __callStatic($name, $arguments)
    {
        $view = new View();
        return call_user_func_array([$view, $name], $arguments);
    }
}