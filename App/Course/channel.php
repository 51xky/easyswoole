<?php
include_once '/xky/easy/vendor/autoload.php';
use Swoole\Coroutine as co;

go(function (){
    var_dump('进入go协程');
    $chan = new co\Channel(12);

    $wait = new \EasySwoole\Component\WaitGroup(12);
    // 并发查询数据，将数据push到channel中
    for($i=1; $i<=12; $i++){
        $wait->add();
        // 由于协程的原理是遇到IO操作，就会保留上下文，进行下一个操作，所以没有等到将数据放到chan中，就已经执行到下面了
        go(function () use ($wait,$chan,$i){
            $time = rand(1,3);
            co::sleep(rand(1,3));
            $chan->push("第{$i}个月数据！，耗时{$time}秒");
            $wait->done();
        });
    }

    // 等待上面的程序执行完成后，再执行下面的代码
    $wait->wait();

    // 将channel中的数据都拿出来并输出到文件中去
    while(true){
        if($chan->isEmpty()){
            break;
        }
        $res = $chan->pop();
        error_log($res.date('H:i:s').PHP_EOL,3,'channel.log');
    }
    error_log('日志文件?'.date('H:i:s').PHP_EOL,3,'channel.log');
});