<?php 

$http = new swoole_http_server("0.0.0.0", 9502);

$http->on("start", function($serv){
	echo "swoole http server is started at http://127.0.0.1:9502".PHP_EOL;
});

$http->set([
	'worker_num'=>1
]);

$http->on("request", function($req, $res){

	if($req->server['path_info'] == '/favicon.ico' || $req->server['request_uri'] == '/favicon.ico'){
		return $res->end();
	}
	//var_dump($req);

	$res->write("hello swoole !!!");
	$res->end();
});

$http->start();

?>