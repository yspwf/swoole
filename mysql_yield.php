<?php 

$server = new Swoole\Http\Server('0.0.0.0', 9502, SWOOLE_BASE);

$server->set(array(
	'worker_num' => 1
));

$server->on('connect', function($serv){
	echo "http server start";
});

$server->on('request', function($req, $res){
	
	$mysql = new Swoole\Coroutine\MySql();

	$db = array(
		'host'=>'127.0.0.1',
		'user'=>'root',
		'password'=>'123456',
		'database'=>'demo'
	);

	$conn = $mysql->connect($db);
	if($conn == false){
		$res->end("mysql connect fail!!");
		return;
	}

	$dbres = $mysql->query("select 1+1");

	$res->end("swoole response is ok, result=".var_dump($dbres, true));

	//$res->write("hello swoole, http request!!");
	///$res->end();
});

$server->start();

?>