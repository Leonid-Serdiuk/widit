<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 24.07.2017
 * Time: 20:57
 */
class Input
{

    public function post($key, $default = false)
    {
        if(isset($_POST[$key]))
            return $_POST[$key];
        else
            return $default;
    }

    public function get($key, $default = false)
    {
        if(isset($_GET[$key]))
            return $_GET[$key];
        else
            return $default;
    }

    public function request($key, $default = false)
    {
        if(isset($_REQUEST[$key]))
            return $_REQUEST[$key];
        else
            return $default;
    }
}