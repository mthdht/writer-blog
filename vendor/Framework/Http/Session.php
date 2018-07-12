<?php
/**
 * @author mthdht
 * @license MIT
 */

namespace Framework\Http;


class Session
{

    public static function get($key)
    {
        if (self::has($key)) {
            return $_SESSION[$key];
        }

        return null;
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }

    public static function delete($key)
    {
        if (self::has($key)) {
            unset($_SESSION[$key]);
        }
    }

    public static function flash($key, $value = null)
    {
        if (is_null($value)) {
            if (isset($_SESSION['flash'][$key])) {
                $flash = $_SESSION['flash'][$key];
                unset($_SESSION['flash'][$key]);
                return $flash;
            }
        }
        $_SESSION['flash'][$key] = $value;
    }

    public static function isAuthenticated()
    {
        return self::get('auth') === true;
    }
}