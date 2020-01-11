<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/5/28
 * Time: 下午6:33
 */

namespace EasySwoole\EasySwoole;


use EasySwoole\EasySwoole\Swoole\EventRegister;
use EasySwoole\EasySwoole\AbstractInterface\Event;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;
use EasySwoole\ORM\Db\Connection;
use EasySwoole\ORM\DbManager;
use EasySwoole\WordsMatch\Exception\RuntimeError;
use EasySwoole\WordsMatch\WordsMatchServer;

class EasySwooleEvent implements Event
{

    public static function initialize()
    {
        date_default_timezone_set('Asia/Shanghai');
    }

    public static function mainServerCreate(EventRegister $register)
    {
        $config = new \EasySwoole\ORM\Db\Config(Config::getInstance()->getConf('MYSQL'));
        DbManager::getInstance()->addConnection(new Connection($config));
        try{
            WordsMatchServer::getInstance()
                ->setMaxMem('1024M') // 每个进程最大内存
                ->setProcessNum(3) // 设置进程数量
                ->setServerName('Easyswoole words-match')// 服务名称
                ->setTempDir(EASYSWOOLE_TEMP_DIR)// temp地址
                ->setWordsMatchPath(EASYSWOOLE_ROOT.'/WordsMatch/')
                ->setDefaultWordBank('comment.txt')// 服务启动时默认导入的词库文件路径
                ->setSeparator(',')// 词和其它信息分隔符
                ->attachToServer(ServerManager::getInstance()->getSwooleServer());
        }catch(RuntimeError $e){
        }catch(\Exception $e){
        }
    }

    public static function onRequest(Request $request, Response $response): bool
    {
        // TODO: Implement onRequest() method.
        return true;
    }

    public static function afterRequest(Request $request, Response $response): void
    {
        // TODO: Implement afterAction() method.
    }
}