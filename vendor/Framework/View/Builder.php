<?php
/**
 * @author mthdht
 * @license MIT
 */

namespace Framework\View;


class Builder
{
    protected $view;
    public $matches;
    public $page;

    public function __construct(View $view)
    {
        $this->view = $view;
    }


    public function hasExtend()
    {
        $content = file_get_contents($this->view->contentFile);
        if (preg_match('#@extend\(\'(.+)\'\)#', $content, $matches)) {
            $this->matches['extend'] = $matches;
            $this->page = file_get_contents($this->view->basePath . preg_replace('#\.#', '/', $matches[1]) . '.php');
            return true;
        }
        $this->page = file_get_contents($this->view->contentFile);
        return false;

    }

    public function parseBlock()
    {
        $this->page = preg_replace_callback('#@generate\(\'(.+)\'\)(.+)#sU', function ($matches) {
            preg_match('#@block\(\'' . $matches[1] .'\'\)(.+)@endblock#sU', file_get_contents($this->view->contentFile), $matche);
            return $matche[1];
        }, $this->page);
        $this->page = preg_replace('/^\h*\v+/m', '', $this->page);

    }

    public function build()
    {
        if ($this->hasExtend()) {
            $this->parseBlock();
        }
        $storageFilePath = ROOT . '/storage/' . $this->view->name . '.php';
        return file_put_contents($storageFilePath, $this->page);
    }

}