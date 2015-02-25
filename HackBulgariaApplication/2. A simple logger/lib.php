<?php

interface MyLogger {
	public function log($level, $message);
}

class BaseLogger implements MyLogger {

	public function log($level, $message) {
	
		if (!is_int($level) || $level < 1 || $level > 3) {
			throw new Exception('The level must be an integer between 1 and 3!');
		}

		switch ($level) {
			case 1:
				$log_level = 'INFO';
				break;
			case 2:
				$log_level = 'WARNING';
				break;
			case 3:
				$log_level = 'PLSCHECKFFS';
				break;
		}

		$log_time = date('c');
		$log_message = $log_level.'::'.$log_time.'::'.$message;

		$this->do_log($log_message);
	}
}

class ConsoleLogger extends BaseLogger {
	protected function do_log($message) {
		echo('<pre>');
		echo($message);
		echo('<br />');
		echo('</pre>');
	}
}

class FileLogger extends BaseLogger {
	function __construct($file) {
       $this->file = $file;
    }

	protected function do_log($message) {
		file_put_contents($this->file, $message.PHP_EOL , FILE_APPEND);
	}
}

class HTTPLogger extends BaseLogger {

	protected function do_log($message) {
		$url = 'http://localhost/task3/log.php';
		$data = array('message' => $message);
		$options = array(
    		'http' => array(
        		'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        		'method'  => 'POST',
        		'content' => http_build_query($data),
   			 )
		);

		$context = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
	}
}

?>