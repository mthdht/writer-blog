<?php
/**
 * @author mthdht
 * @license MIT
 */

namespace Framework\View;


class View
{
    public $contentFile;
    public $basePath;
    public $data;
    public $name;

    public function __construct($content, $data)
    {
        $this->basePath = ROOT . '/ressources/';
        $this->contentFile = $this->basePath . preg_replace('#\.#', '/', $content) . '.php';
        $this->data = $data;
        $this->name = $content;
    }

    protected function make()
    {
        $builder = new Builder($this);
        $builder->build();

        return $this;
    }

    public function render()
    {
        extract($this->data);
        require ROOT.'/storage/'.$this->name.'.php';
    }

    public static function __callStatic($name, $arguments)
    {
        $view = new View(...$arguments);
        return call_user_func([$view, $name]);
    }
}