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

	var_dump("stime:". microtime(true));

	$client = new Swoole\Coroutine\Client(SWOOLE_SOCK_TCP);
	var_dump("new :". microtime(true));

	if(!$client->connect('0.0.0.0', 9503, 0.5)){
		return $res->end('swoole response error:'. $client->errCode);
	}

	var_dump("connect :" . microtime(true));

	$client->send("hello YSP \r\n");

	var_dump('send:'.microtime(true));

	echo "from server: ".$client->recv(5);

    var_dump('recv:' . microtime(true));
    $client->close();

	$res->write("hello swoole !!!");
	$res->end();
});

$http->start();

?>