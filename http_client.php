<?php 

$client = new swoole_client(SWOOLE_SOCK_TCP);
if (!$client->connect('192.168.114.128', 9503, -1))
{
    exit("connect failed. Error: {$client->errCode}\n");
}
$client->send("hello world\n");
echo $client->recv();
$client->close();

?>