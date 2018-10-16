<?php 

$client = new Swoole\Client(SWOOLE_TCP_SOCK, SWOOLE_TCP_ASYNC);

if(!$client->connect('192.168.114.128',-1)){
	exit("connect failed , Error:{$client->errCode} \r\n");
}

$client->send("cleint send data \r\n");

echo $client->recv();

$client->close();

?>