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

    /**
     * Clear current session variable
     * @param string $session_id
     * @return bool
     */
    public function destroy($session_id) {
        $log_data = ['delete' =>['ID' => $session_id]];
        App::logger($log_data);
        $this->redis->del(self::Prefix.$session_id);
	    return true;
    }

    public function gc($maxlifetime) {
	    return true;
    }

    public function open($save_path, $name) {
        return true;
    }

    /**
     * Reads data from current session
     * @param string $session_id
     * @return string
     */
    public function read($session_id) {
        $result = $this->redis->get(self::Prefix.$session_id);
        $log_data = ['read' => ['ID' => $session_id]];
        App::logger($log_data);
        return $result ? $result : '';

    }

    /**
     * Writes data to current session
     * @param string $session_id
     * @param string $session_data
     * @return bool
     */
    public function write($session_id, $session_data) {
	    $this->redis->set(self::Prefix.$session_id, $session_data);
	    $log_data = ['write' =>['ID' => $session_id, 'Data' => $session_data]];
	    App::logger($log_data);
	    return true;
    }
}