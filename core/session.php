<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 09.05.2017
 * Time: 18:44
 */
class Session
{
    public function get($name, $default = null)
    {
        if(!self::exists())
            session_start();
        return ( isset($_SESSION[$name]) ) ? $_SESSION[$name] : $default;
    }

    public function set($name, $value)
    {
        if(!self::exists())
            session_start();
        $_SESSION[$name] = $value;
        //session_write_close();
    }

    public function unset($name)
    {
        unset($_SESSION[$name]);
    }

    public function exists()
    {
        return empty(session_id()) ? false : true;
    }
}