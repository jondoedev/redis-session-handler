<?php

require_once 'App.php';
use Engine\App;

return[
    [
        'method' => 'GET',
        'pattern' => '/',
        'handler' => function($request){
            if (isset($_SESSION['count'])) {
                $_SESSION['count']++;
            } else {
                 $_SESSION['count'] = 1;
            }

            return (string)$_SESSION['count'];
        }
    ],
];