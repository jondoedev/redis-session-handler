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
        $redisHandler = new CustomHandler();
        session_set_save_handler($redisHandler);
        session_start();
        self::$config = require_once(__DIR__ . '/../config.php');
    }

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
        //TODO:: FIX: read and write CustomHandler methods comes to separate files;

    public static function logger(array $log_data)
    {

        $current_date = date('d-m-Y');
        self::$logfile = self::$config['log_dir'].'log_'.$current_date.'.txt';
        file_put_contents(self::$logfile, json_encode($log_data) . "\n", FILE_APPEND);
    }


    public static function getSessionId(){
        $request['params'] = $_REQUEST;
        if (isset($request['params']['key'])) {
            $session_id = $request['params']['key'];
            return (string)$session_id;
        }
    }
    public static function getSessionData(){
        $request['params'] = $_REQUEST;
        if (isset($request['params']['value'])) {
            $session_data = $request['params']['value'];
            return (string)$session_data;
        }
    }

}
