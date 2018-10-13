<?php 

$client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);

$client->on('connect', function($cli){
	$cli->send("hello  this is swoole client \r\n");
});


$client->on('receive', function($cli, $data){
	echo "receive ".$data."\r\n";
});


$client->on('error', function($cli){
	echo "connect failed\r\n";
});

$client->on('close', function($cli){
	echo "connection close \r\n";
});

$client->connect('127.0.0.1', 9502);
?>