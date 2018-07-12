<?php
/**
 * @author mthdht
 * @license MIt
 */

namespace Framework\Config;


class Config
{
    private $config;
    private static $instance;

    public function __construct($file)
    {
        $this->config = require $file;
    }

    public static function get($key)
    {
        return self::getInstance()->config[$key];
    }

    private static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Config(ROOT . '/config/config.php');
            return self::$instance;
        }
        return self::$instance;
    }
}