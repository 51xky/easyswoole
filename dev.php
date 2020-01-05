<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2019-01-01
 * Time: 20:06
 */

return [
    'SERVER_NAME' => "EasySwoole",
    'MAIN_SERVER' => [
        'LISTEN_ADDRESS' => '0.0.0.0',
        'PORT' => 9501,
        'SERVER_TYPE' => EASYSWOOLE_WEB_SERVER, //可选为 EASYSWOOLE_SERVER  EASYSWOOLE_WEB_SERVER EASYSWOOLE_WEB_SOCKET_SERVER,EASYSWOOLE_REDIS_SERVER
        'SOCK_TYPE' => SWOOLE_TCP,
        'RUN_MODEL' => SWOOLE_PROCESS,
        'SETTING' => [
            'worker_num' => 8,// 运行的 worker 进程数量
            'reload_async' => true,// 设置异步重启开关。设置为true时，将启用异步安全重启特性，Worker进程会等待异步事件完成后再退出。
            'max_wait_time'=>3
        ],
        'TASK'=>['workerNum'=>4,'maxRunningNum'=>128,'timeout'=>15]
    ],
    'TEMP_DIR' => null,
    'LOG_DIR' => null,
    'MYSQL'         => [
        'host'          => '127.0.0.1',
        'port'          => 3306,
        'user'          => 'root',
        'password'      => 'root',
        'database'      => 'test',
        'timeout'       => 5,
        'charset'       => 'utf8mb4',
        'POOL_MAX_NUM'  => 20,
        'POOL_TIME_OUT' => 1
    ],
];
