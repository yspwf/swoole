<?php 

$server = new swoole_server("0.0.0.0", 9503);

$server->set(array(
	'worker_num' => 4,
	'task_worker_num'=>4
));

$server->on('connect', function($serv, $fd){
	echo "client connect: {$fd}";
});

$server->on('WorkerStart', function($serv, $work_id){
	require  __DIR__.'/demo.php';
});

$server->on('receive', function($serv, $fd, $reactor_id, $data){
	echo $data.PHP_EOL;

    $demo = new Demo();
    $data = $demo->test();
    echo "function -------".PHP_EOL; 
    echo $data.PHP_EOL;
    echo "function -------".PHP_EOL; 

    echo "GET -----".PHP_EOL;
    echo $_GET['a'];
    echo "GET ----".PHP_EOL;


	$serv->send($fd,'data  received');
	$serv->task("33333333");
	$serv->close($fd);
});


$server->on('task', function($serv, $fd, $task_id, $data){
	echo $data.PHP_EOL;
	$serv->finish($data);
});

$server->on('finish', function($serv, $task_id, $data){
	echo "finish task {$task_id}".PHP_EOL;
});

$server->on('close', function($serv, $fd){
	echo "client close".PHP_EOL;
});

$server->start();

?>
