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
        'handler' => function($request){
          return  App::render('main');
        }
    ],[
        'method' => 'POST',
        'pattern' => '/',
        'handler' => function($request){
            $_SESSION[App::getSessionKey()] = App::getSessionValue();
            return main($request);
        }
    ],
    [
        'method' => 'GET',
        'pattern' => '/delete',
        'handler' => function($request){
            return App::render('delete');

        }
    ],
    [
        'method' => 'POST',
        'pattern' => '/delete',
        'handler' => function($request){
            unset($_SESSION[Engine\CustomHandler::Prefix.session_id()]);
            session_destroy();
            return App::render('delete');
        }
    ],

];