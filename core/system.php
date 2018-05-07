<?php

class System
{
    private static $session;

    public static function init()
    {
        self::$session = new Session();
    }

    public static function redirect($path)
    {
        header("location: ".$path);
    }

    public static function site_url($path, $to_print = true)
    {
        $url = URL . '/' . $path;
        if ($to_print)
        {
            echo $url;
        }
        else
        {
            return $url;
        }
    }

    public static function set_alert($message, $type = 'info')
    {
        $type = ( !in_array( $type, array( 'success', 'danger', 'error', 'info', 'warning', 'default' ) ) ) ? 'info' : $type;
        $message = (empty($message)) ? '<strong>' . strtoupper($type) . '!</strong>' : $message;
        self::$session->set('alert-type', $type);
        self::$session->set('alert-message', $message);
    }

    public static function alert_type($to_print = true)
    {
        $type = '';
        $type .= self::$session->get('alert-type');

        if ($to_print) {
            echo $type;
            self::$session->unset('alert-type');
        }
        else
            return $type;
    }

    public static function alert_message($to_print = true)
    {
        $message = self::$session->get('alert-message', '');
        if ($to_print)
        {
            echo $message;
            self::$session->unset('alert-message');
        }
        else
            return $message;
    }

}