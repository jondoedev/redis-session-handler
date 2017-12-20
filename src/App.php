<?php


namespace App;

use ArrayAccess;
use  Engine\CustomHandler;
require_once 'CustomHandler.php';

class App
{
    public static $config;
    public static $logfile;
    public static function init()
    {
        self::$config = require_once(__DIR__ . '/../config.php');
        $redisHandler = new CustomHandler();
        session_set_save_handler($redisHandler);
        session_start();
    }

    /**
     * method de
     * @param $relative_url
     * @return string
     */
    public static function url($relative_url)
    {
        return self::$config['base_url'] . $relative_url;
    }
    public static function run($request)
    {
        $routes = require_once __DIR__ . '/routes.php';

        foreach ($routes as $route) {
            $pattern = $route['pattern'];
            $handler = $route['handler'];
            $method = $route['method'];

            $url_without_params = strtok($request['url'], '?');
            $pattern = '/^' . str_replace('/', '\/', self::url($pattern)) . '$/';
            $matches = [];
            preg_match($pattern, $url_without_params, $matches);

            if ($matches && ($request['method'] == $method)) {
                $args = array_merge([$request], array_slice($matches, 1));

                    $response = call_user_func_array($handler, $args);

                    if (is_string($response)) {
                        $response = [
                            'code' => 200,
                            'body' => $response
                        ];
                    }
                    return $response;
                }
        }

        return [
            'code' => 404,
            'body' => json_encode('404 Not Found')
        ];
    }


    /**
     * Improving convenient views rendering
     */
    public static function render($path)
    {
        ob_start();
        require_once __DIR__ . "/../views/$path.php";
        $output = ob_get_clean();
        return $output;
    }

    /**
     * saving given data to the specified file
     * @param array $log_data
     */
    public static function logger(array $log_data)
    {
        $timestamp = date('h:i:s');
        $current_date = date('d-m-Y');
        self::$logfile = self::$config['log_dir'].'log_'.$current_date.'.txt';
        file_put_contents(self::$logfile, $timestamp.': |'.json_encode($log_data) . "\n", FILE_APPEND);
    }

    /**
     * stores data sent by POST HTTP Method to session variable
     * @return string
     */
    public static function getSessionKey(){
        $request['params'] = $_REQUEST;
        if (isset($request['params']['key'])) {
            $session_key = $request['params']['key'];
            return (string)$session_key;
        }
    }
    /**
     * stores data sent by POST HTTP Method to session variable
     * @return string
     */
    public static function getSessionValue(){
        $request['params'] = $_REQUEST;
        if (isset($request['params']['value'])) {
            $session_value = $request['params']['value'];
            return (string)$session_value;
        }
    }

    public static function getFullData(){
        $data = [
            'key' => self::getSessionKey(),
            'value' => self::getSessionValue()
        ];
            foreach ($data as $key => $value){
                echo $key . ': ' . $value.'<br>';
            }
    }

}
