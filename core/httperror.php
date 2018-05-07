<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 02.04.2017
 * Time: 12:41
 * @property array default_message
 */
class HttpError
{
    private static $status_name = array(
        '400' => "400 Bad Request",
        '404' => "404 Not Found",
        '403' => "403 Forbidden",
        '500' => "500 Internal Server Error",
        '503' => "503 Service Unavailable"
    );

    private static $default_message = array(
        '400' => "Bad request",
        '404' => "Page not found",
        '403' => "Forbidden",
        '500' => "Server error",
        '503' => "Service anavalible"
    );

    public static function show($status, $message = NULL)
    {
        $message = (!$message) ? self::$default_message[$status] : $message;
        header('HTTP/1.1 '.self::$status_name[$status].'.', TRUE, $status);
        echo $message;
        exit(1); // EXIT_ERROR
    }
}