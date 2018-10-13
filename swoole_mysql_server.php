<?php 

$server = new swoole_server("127.0.0.1", 9502);

$server->on('connect', function($serv, $fd){
	echo "connect fd : {$fd}";
});

$server->on('receive', function($serv, $fd, $reactor_id, $data){
	echo "receive data: {$data}".PHP_EOL;
	$serv->send($fd, "swoole receive data: {$data}");
	$serv->close($fd);
});

$server->on('close', function($serv, $fd){
	echo "client close: {$fd}";
});

$server->start();


?>