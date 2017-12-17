<?php


namespace Engine;

use Predis\Client;
use SessionHandlerInterface;


class CustomHandler implements SessionHandlerInterface
{

    protected $redis;

    public function __construct($host='127.0.0.1', $port=6379, $database=0)
    {
	    $this->redis = new Client([
		    'host'   => $host,
		    'port'   => $port,
	    ], [
	    	'parameters' => [
	    		'database' => $database
		    ]
	    ]);
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
    	$result = $this->redis->get($session_id);
	    return $result ? $result : '';
    }

    public function write($session_id, $session_data) {
	    $this->redis->set($session_id, $session_data);
	    return true;
    }
}