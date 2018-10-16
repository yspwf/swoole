<?php 

$client = new swoole_client(SWOOLE_SOCK_TCP,SWOOLE_SOCK_ASYNC);

if(!$client->connect('192.168.114.128',9503,-1)){
	exit("connect failed , Error:{$client->errCode} \r\n");
}

$client->send("cleint send data \r\n");

echo $client->recv();

$client->close();

?>