<?php
/**
 * Created by PhpStorm.
 * User: 吴凯斌
 * Date: 2018/12/18
 * Time: 22:21
 */
//创建server对象,监听127.0.0.1:9501端口
$server = new swoole_server("127.0.0.1", 9501);

//绑定参数
$server->set([
    'worker_num' => 8, //cup核心数的1-4倍
    'max_request' => 10000, //
]);


//监听连接进入事件
/**
 * $fd客户端连接唯一标志
 * $reactor_id 线程id
 */
$server->on('connect', function ($server, $fd, $reactor_id) {
    echo "client: {$reactor_id}-{$fd}-Connect.\n";
});


//监听数据接受事件
$server->on('receive', function ($server, $fd, $reactor_id, $data) {
    $server->send($fd, "server: {$reactor_id}-{$fd}".$data);
});

//监听连接关闭事件
$server->on('close', function ($server, $fd) {
    echo "client: Close.\n";
});

//启动服务器
$server->start();
