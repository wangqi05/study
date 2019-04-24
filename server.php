<?php
$server = new swoole_websocket_server("0.0.0.0", 9503);
$server->on('open', function (swoole_websocket_server $server, $request) {
	echo "server: handshake success with fd{$request->fd}\n";
});
$server->on('message', function (swoole_websocket_server $server, $frame) {
	echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
	$data = $frame->data;
	foreach($server->connections as $fd){
		$server->push($fd , $data);
	}
});

$server->on('close', function ($ser, $fd) {
	echo "client {$fd} closed\n";
});

$server->start();