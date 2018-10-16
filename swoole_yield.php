<?php 

$http = new swoole_http("127.0.0.1", 9503);

$http->on("start", function($serv){
	echo "swoole http server is started at http://127.0.0.1:9053".PHP_EOL;
});

$http->on("request", function($req, $res){
	var_dump($req);

	$res->write("hello swoole !!!");
	$res->end();
});

$http->start();

?>