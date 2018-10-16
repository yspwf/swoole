<?php 

$server = new Swoole\Http\Server('0.0.0.0', 9502, SWOOLE_BASE);

$server->set(array(
	'worker_num' => 1
));

$server->on('connect', function($serv){
	echo "http server start";
});

$server->on('request', function($req, $res){
	$res->write("hello swoole, http request!!");
	$res->end();
});

$server->start();

?>