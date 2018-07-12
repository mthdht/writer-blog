<?php
/**
 * @author mthdht
 * @license MIT
 */

namespace Framework\Http;


class Response
{
    private $content;

    private $headers;

    private $statusCode;


    public function __construct($content, $statusCode = 200, $headers = [])
    {
        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    public static function create($content = '', $statusCode = 200, $headers = array())
    {
        return new static($content, $statusCode, $headers);
    }

    public function header($header)
    {
        $this->headers[] = $header;
        return $this;
    }

    public function cookie($name, $value, $time = 0, $path = null, $domain = null, $secure = false, $httpOnly = true)
    {
        setcookie($name, $value, time() + $time * 60, $path, $domain, $secure, $httpOnly);
        return $this;
    }

    public function redirect($location)
    {
        header('Location: ' . $location);
    }

    public function send() {
        foreach ($this->headers as $header) {
            header($header);
        }
        echo $this->content;
        exit;
    }




}