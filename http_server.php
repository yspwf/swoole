<?php 

$server = new swoole_server("0.0.0.0", 9503);

$server->on('connect', function($serv, $fd){
	echo "client connect: {$fd}";
});

$server->on('receive', function($serv, $fd, $reactor_id, $data){
	echo $data.PHP_EOL;
	$serv->send($fd,'data  received');
	$serv->close($fd);
});

$server->on('close', function($serv, $fd){
	echo "client close".PHP_EOL;
});

$server->start();

?>