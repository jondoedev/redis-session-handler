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
    	return true;
    }

    public function destroy($session_id) {
	    return true;
    }

    public function gc($maxlifetime) {
	    return true;
    }

    public function open($save_path, $name) {
        return true;
    }

    public function read($session_id) {
	    return (file_exists(__DIR__.'/'.$session_id)) ? file_get_contents(__DIR__.'/'.$session_id) : '';
    }

    public function write($session_id, $session_data) {
	    file_put_contents(__DIR__.'/'.$session_id, $session_data);
	    return true;
    }
}