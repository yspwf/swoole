<?php 

class SwooleServer{
	private $serv;

	public function __construct(){
		$this->serv = new swoole_server("127.0.0.1", 9502);
		$this->serv->set([
				'worker_num'=>8,
				'task_worker_num'=>8
			]
		);

		$this->serv->on('connect', array($this,'onConnect'));
		$this->serv->on('receive', array($this,'onReceive'));
		$this->serv->on('close', array($this,'onClose'));
		$this->serv->on('task', array($this,'onTask'));
		$this->serv->on('finish', array($this,'onFinish'));
		$this->serv->start();
	}

	public function onConnect(){
		echo "connect fd : {$fd}".PHP_EOL;
	}

	public function onReceive($serv, $fd, $reactor_id, $data){
		echo "receive data: {$data}".PHP_EOL;
		//$serv->send($fd, "swoole receive data: {$data}");
		$params = [
			'fd'=>$fd,
			'data'=>$data
		];
		$res = $serv->task(json_encode($params));
		echo "------".$res.PHP_EOL;
		echo "Continue Handle Worker".PHP_EOL;
		$serv->close($fd);
	}

	public function onTask($serv, $task_id, $from_id, $data){
		echo "task  ".PHP_EOL;
		var_dump($data);
		echo "over  ".PHP_EOL;
		$fd = json_decode($data, true)['fd'];
		$serv->send($fd, "swoole task data: 1,2,3,4,5,6...");
		//return "task over";
		$serv->finish($data);
	}

	public function onFinish($serv, $task_id, $data){
		echo "Task {$task_id} finish".PHP_EOL;
		echo "----".PHP_EOL;
	    var_dump($data);
	    echo "----".PHP_EOL;
	}

	public function onClose($serv, $fd){
		echo "client close: {$fd}".PHP_EOL;
	}

}

$server = new SwooleServer();

/*
$server = new swoole_server("127.0.0.1", 9502);

$server->set([
	'task_worker_num' => 8
]);

$server->on('connect', function($serv, $fd){
	echo "connect fd : {$fd}".PHP_EOL;
});

$server->on('receive', function($serv, $fd, $reactor_id, $data){
	echo "receive data: {$data}".PHP_EOL;
	//$serv->send($fd, "swoole receive data: {$data}");
	$params = [
		'fd'=>$fd,
		'data'=>$data
	];
	$res = $serv->task(json_encode($params));
	echo "------".$res.PHP_EOL;
	echo "Continue Handle Worker".PHP_EOL;
	$serv->close($fd);
});

$server->on('task', function($serv, $task_id, $from_id, $data){
	echo "task  ".PHP_EOL;
	var_dump($data);
	echo "over  ".PHP_EOL;
	$fd = json_decode($data, true)['fd'];
	$serv->send($fd, "swoole task data: 1,2,3,4,5,6...");
	//return "task over";
	$serv->finish($data);
});

$server->on('finish', function($serv, $task_id, $data){
	echo "Task {$task_id} finish".PHP_EOL;
	echo "----".PHP_EOL;
    var_dump($data);
    echo "----".PHP_EOL;
});

$server->on('close', function($serv, $fd){
	echo "client close: {$fd}".PHP_EOL;
});

$server->start();
*/

?>