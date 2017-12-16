<?php


namespace Engine;
use Engine\LogEngine as Engine;
class App
{
    public static $logfile;
    public static $config;
    public static function init() {
        $redisHandler = new CustomHandler(/*'127.0.0.1', 6379, 1*/);
//        session_set_save_handler($redisHandler);
        session_start();
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
            'body' => 'NOT FOUND'
        ];
    }

    public static function render($path)
    {
        ob_start();
        require_once __DIR__ . "/../views/$path.php";
        $output = ob_get_clean();
        return $output;
    }

    public static function url($relative_url)
    {
        self::$config = require_once(__DIR__ . '/../config.php');
        return self::$config['base_url'] . $relative_url;
    }

    public static function logger()
    {
        $data = 'SESSIONDATA';
        $current_date = date('d-m-Y');
        self::$logfile = self::$config['log_dir'].'log_'.$current_date.'.txt';
        file_put_contents(self::$logfile, $data . "\n", FILE_APPEND);
    }
}