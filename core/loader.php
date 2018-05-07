<?php

class Loader {

    private $current_controller;

    function __construct(&$controller)
    {
        $this->current_controller = $controller;
    }



    public static function letsGo() {
        self::_load('router');
        self::_load('model');
        self::_load('view');
        self::_load('controller');
        list($controller, $method, $args) = Router::parseUrl(false);
        $controller = self::_loadController($controller);
        self::_loadMethod($controller, $method, $args);
    }

    public static function getLibrary($name, $isCore = false) {
        if ($isCore)
        {
            self::_load($name);
        }
        else
        {
            $file_path = APP_PATH.'libs'.DS.strtolower($name).'.php';
            if (file_exists($file_path)) {
                require_once ($file_path);
            } else {
                HttpError::show(503, 'file '.$file_path.' does not exists.');
            }
        }
    }

    public static function getHelper($name, $isCore = false) {
        if ($isCore)
        {
            self::_load($name);
        }
        else
        {
            $file_path = APP_PATH.'helpers'.DS.strtolower($name).'.php';
            if (file_exists($file_path)) {
                require_once ($file_path);
            } else {
                HttpError::show(503, 'file '.$file_path.' does not exists.');
            }
        }
    }

    public function getModel($name)
    {
        $name = (strpos($name, "_model")) ? strtolower($name) : strtolower($name)."_model" ;
        $file_path = APP_PATH.'models'.DS.$name.'.php';
        if (file_exists($file_path)) {
            require_once ($file_path);
        } else {
            HttpError::show(503, 'file '.$file_path.' does not exists.');
        }
        $model_name = ucfirst($name);
        $this->current_controller->$name = new $model_name();
    }

    private static function _load($className) {
        $file_path = CORE_PATH.strtolower($className).'.php';
        if (file_exists($file_path)) {
            require_once ($file_path);
        } else {
            HttpError::show(503, 'file '.$file_path.' does not exists.');
        }
    }

    private static function _loadController($controllerClass)
    {
        $file_path = APP_PATH.'controllers'.DS.strtolower($controllerClass).'.php';
        if (file_exists($file_path))
        {
            require_once ($file_path);
            if (class_exists($controllerClass))
            {
                $controller = new $controllerClass();
                return $controller;
            }
        }
        else
        {
            HttpError::show(404);
        }
    }

    private static function _loadMethod($controller, $method, $args) {
        if(method_exists($controller, $method))
        {
            call_user_func(array($controller, $method), $args);
        }
        else
        {
            HttpError::show(404);
        }
    }
}
