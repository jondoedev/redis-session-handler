<?php


namespace Engine;

use App\App;
use Predis\Client;
use SessionHandlerInterface;


class CustomHandler implements SessionHandlerInterface
{

    public $redis;
    const Prefix = 'kalenyuk: ';
    public function __construct($host='127.0.0.1', $port=6379, $database=15)

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
        $session_id = App::getSessionId();
        $result = $this->redis->del(self::Prefix.$session_id);
        session_destroy();
	    return $result;
    }

    public function gc($maxlifetime) {
	    return true;
    }

    public function open($save_path, $name) {
        return true;
    }

    public function read($session_id) {
        $session_id = App::getSessionId();
        $result = $this->redis->get($session_id);
        $log_data = ['read' =>
            ['ID' => $session_id]
        ];
        App::logger($log_data);
        return $result ? $result : '';

    }

    public function write($session_id, $session_data) {
        $session_data = App::getSessionData();
        $session_id = App::getSessionId();
	    $this->redis->set(self::Prefix.$session_id, $session_data);
	    $log_data = ['write' =>
            ['ID' => $session_id, 'Data' => $session_data]
        ];
	    App::logger($log_data);
	    return true;
    }
}