<?php
require_once 'App.php';
use App\App;
use Predis\Client;
use Engine\CustomHandler;

function main($request){
    if ($request['method'] == 'POST') {
        if (isset($request['params']['key']) && ($request['params']['key'] != 0)){
            $_SESSION['mySession'] = $request['params']['key'];
            return (string) $_SESSION['mySession'];
        }
    }



    return App::render('main');
}

return [

    [
        'method' => 'GET',
        'pattern' => '/',
        'handler' => function ($request) {
            return main($request);
        }
    ],
    [
        'method' => 'POST',
        'pattern' => '/',
        'handler' => function ($request) {
            return main($request);
        }
    ],
    [
        'method' => 'GET',
        'pattern' => '/bla',
        'handler' => function($request){
            return 'OKsd';
        }
    ],

    [
        'method' => 'GET',
        'pattern' => '/example',
        'handler' => function($request){
            if (isset($_SESSION['count'])) {
                $_SESSION['count']++;
            } else {
                $_SESSION['count'] = 1;
            }
            return (string)$_SESSION['count'];
        }
    ],

    [
        'method' => 'GET',
        'pattern' => '/destroy',
        'handler' => function($request){
            return main($request);

        }
    ],

    //TODO:: Make it Work!!!
    [
        'method' => 'POST',
        'pattern' => '/destroy',
        'handler' => function($request){
            $redis = new Client([
                'host'   => '127.0.0.1',
                'port'   => '6379',
            ], [
                'parameters' => [
                    'database' => 15
                ]
            ]);
            $prefix = CustomHandler::Prefix;
            $session_id = App::getSessionId();
            $result = $redis->del($prefix.$session_id);
            echo $result;
            return $result;

        }
    ],

];