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

    public static function make($viewFile, $data = [])
    {
        $instance = new static($viewFile, $data);
        $builder = new Builder($instance);
        $builder->build();

        return $instance;
    }

    public function render()
    {
        if (isset($this->data)) {
            extract($this->data);
        }
        ob_start();
        require ROOT.'/storage/'.$this->name.'.php';
        return ob_get_clean();
    }
}