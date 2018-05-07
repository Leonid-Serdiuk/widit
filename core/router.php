<?php
/**
 * Add routes here.
 * To add router need to call Router::addRoute($route, $destination) method with first param $route and second param $destination
 * Routes can be "/", "controller_name", "controller_name/method_name", "controller_name/method_name/$args".
 */
Router::addRoute('/','dashboard/index');
Router::addRoute('profit/month/$args','profit/index');
Router::addRoute('profit/week/$args','profit/index');
Router::addRoute('profit/day/$args','profit/index');
Router::addRoute('expenses/month/$args','expenses/index');
Router::addRoute('expenses/week/$args','expenses/index');
Router::addRoute('expenses/day/$args','expenses/index');
/**
 * Class Router
 */
class Router {
    /** @var routes keeps arrray of routes*/
    private static $routes = array();

    /**
     * Takes url sring and parses like array
     * @return array type array([0] => 'controller_name', [1] => 'method_name', [3] => array([0] => 'arg1', [1] => 'arg2'))
     */
    public static function parseUrl($not_processed = true) {
        // Url processing
        $url = isset($_GET['url']) ? $_GET['url'] : NULL;
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        // Url to array
        $url_array = explode('/', $url);
        $not_processed_url_array = $url_array;
        // Proccess routes depending on the number of items
        if (count($url_array) <= 2) {
            $key = $url;
            self::proccessRoute($key, $url_array);
        }
        else
        {
            $key = $url_array[0].'/'.$url_array[1].'/$args';
            self::proccessRoute($key, $url_array);
        }
        return ($not_processed) ? $not_processed_url_array : $url_array;
    }

    /**
     * Checks routes and replace url array with desination route.
     * @param $key possible rout
     * @param $url_array link to current url array
     * @return void
     */
    private static function proccessRoute($key, &$url_array) {
        // Get routes array
        $routes = self::$routes;
        // Check for index route
        $key = ($key == "") ? '/' : $key;
        // Replace controller and method if route according url
        if (isset($routes[$key]))
        {
            $url_array[0] = $routes[$key]['controller'];
            $url_array[1] = $routes[$key]['method'];
            $url_array[2] = (isset($url_array[2])) ? array_slice($url_array, 2) : NULL;
        }
        else
        {
            $url_array[1] = (isset($url_array[1])) ? $url_array[1] : "index";
            $url_array[2] = (isset($url_array[2])) ? array_slice($url_array, 2) : NULL;
        }
    }

    /**
     * Adds new route
     * @param $route
     * @param $destination
     * @return void
     */
    public static function addRoute($route, $destination) {
        // Process destination route
        $destination = rtrim($destination, '/');
        $destination = filter_var($destination, FILTER_SANITIZE_URL);
        $destination_arr = explode('/', $destination);
        // Show error if rout did not add correctly
        if (count($destination_arr) > 2) {
            HttpError::show(503, 'Invalid route destination: '.$destination.'. Please read documentation about routes');
        }
        // Check source routes and add to routes array or show error
        if ($route == '/' || preg_match('/^\w+$/i',$route) || preg_match('/^\w+\/\w+$/i',$route) || preg_match('/^\w+\/\w+\/\$args$/i',$route)) {
            self::$routes[$route] = array(
                'controller' => $destination_arr[0],
                'method' => isset($destination_arr[1]) ? $destination_arr[1] : 'index'
            );
        }
        else
            HttpError::show(503, 'Invalid route: '.$route.'. Please read documentation about routes');
    }

}