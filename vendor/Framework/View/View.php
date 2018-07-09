<?php
/**
 * @author mthdht
 * @license MIT
 */

namespace Framework\View;


class View
{
    protected $contentFile;
    protected $basePath;
    protected $data;
    protected $content;
    protected $storageFilePath;

    public function __construct()
    {
        $this->basePath = ROOT . '/ressources/';
    }

    protected function make($content, $data = [])
    {
        $this->contentFile = $this->basePath . preg_replace('#\.#', '/', $content) . '.php';
        $this->data = $data;
        $this->content = $content;
        return $this;
    }

    public function render()
    {
        foreach ($this->data as $key => $value) {
            ${$key} = $value;
        }

        $this->build();
        require ROOT.'/storage/'.$this->content.'.php';
    }

    public function parseContent()
    {

    }

    public function parseExtend($file)
    {
        $file = preg_replace_callback('#@extend\(\'(.+)\'\)(.*)#s', function ($matches) {
            $layoutPath = $this->basePath . preg_replace('#\.#', '/', $matches[1]) . '.php';
            return $matches[2] . "<?php require '$layoutPath'; ";
        }, $file);

        return $file;
    }

    public function parseSection()
    {
        $content = file_get_contents($this->contentFile);

        $content = preg_replace_callback('#@section\(\'(.+)\'\)(.*)@endsection#sU', function($matches) {
            return "<?php ob_start(); ?>" . $matches[2] . "<?php $" . $matches[1] . " = ob_get_clean(); ?>";
        }, $content);

        return $content;
    }

    public function build()
    {
        $content = $this->parseSection();
        $content = $this->parseExtend($content);
        $content = preg_replace('/^\h*\v+/m', '', $content);

        if (!file_exists(ROOT . '/storage/' . $this->content . '.php')) {
            $this->storageFilePath = ROOT . '/storage/' . $this->content . '.php';
            file_put_contents($this->storageFilePath, $content);
        }
    }

    public static function __callStatic($name, $arguments)
    {
        $view = new View();
        return call_user_func_array([$view, $name], $arguments);
    }
}