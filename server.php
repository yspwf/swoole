<?php

$server = new swoole_server("0.0.0.0", 9503);

$server->on('connect', function($serv, $fd){
	echo "server connection open: {$fd}".PHP_EOL;
});


$server->on('receive', function($serv, $fd, $reactor_id, $data){
	$serv->send($fd,"hahaha");
	$serv->close($fd);
});

$server->on('close', function($serv, $fd){
	echo "connection close : {$fd}".PHP_EOL;
});

$server->start();
?>