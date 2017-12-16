<?php


namespace Engine;

use SessionHandlerInterface;
//use Redis;


class CustomHandler implements SessionHandlerInterface
{

//    protected $redis_credentials;
//    protected $location;
//    protected $port;
//    protected $db;
//    protected $log;
//    const SIGNATURE = 'kalenyukk';

    public function __construct(/*$location, $port, $db*/)
    {
//        $this->location = $location;
//        $this->port = $port;
//        $this->db = $db;
    }

    public function close() {
        echo 'close';
    }

    public function destroy($session_id) {
        echo 'destroy';
    }

    public function gc($maxlifetime) {
        echo 'gc';
    }

    public function open($save_path, $name) {
        echo 'open';
    }

    public function read($session_id) {
        echo 'read';
    }

    public function write($session_id, $session_data) {
        echo 'write';

    }
}