<?php
/**
 * @author mthdht
 * @license MIT
 */

namespace Framework\Http;


class Request
{
    public $cookies;

    public $post;

    public $get;

    public $file;

    public $server;

    public function __construct()
    {
        $this->session = $_SESSION;
        $this->cookies = $_COOKIE;
        $this->post = $_POST;
        $this->get = $_GET;
        $this->server = $_SERVER;
        $this->file = $_FILES;
    }

    public function method() {
        return $this->server['REQUEST_METHOD'];
    }

    public function isMethod($method)
    {
        return strtolower($this->method()) == strtolower($method);
    }

    public function path()
    {
        return parse_url($this->server['REQUEST_URI'])['path'];
    }

    public function url()
    {
        return $this->server['SERVER_NAME'] . $this->server['REQUEST_URI'];
    }

    public function query($key = null)
    {
        if (is_null($key)) {
            return $this->get;
        }

        return isset($this->get[$key]) ? $this->get[$key] : null;
    }

    public function all()
    {
        return $this->post;
    }

    public function input($name)
    {
        return isset($this->post[$name]) ? $this->post[$name] : null;
    }

    public function has($name)
    {
        return isset($this->post[$name]);
    }

    public function file($name)
    {
        return isset($this->file[$name]) ? $this->file[$name] : null;
    }

    public function cookie($name)
    {
        return isset($this->cookies[$name]) ? $this->cookies[$name] : null;
    }

    public function __get($name)
    {
        return $this->input($name);
    }
}