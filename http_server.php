<?php 

$server = new swoole_server("0.0.0.0", 9503);

$server->set(array(
	'worker_num' => 4,
	'task_worker_num'=>4
));

$server->on('connect', function($serv, $fd){
	echo "client connect: {$fd}";
});

$server->on('WorkStart', function($serv, $work_id){
	require './demo.php';
});

$server->on('receive', function($serv, $fd, $reactor_id, $data){
	echo $data.PHP_EOL;

    $demo = new Demo();
    $data = $demo->test();
    echo $data.PHP_EOL;
    echo "-------".PHP_EOL; 

	$serv->send($fd,'data  received');
	$serv->close($fd);
});

$server->on('close', function($serv, $fd){
	echo "client close".PHP_EOL;
});

$server->start();

?>