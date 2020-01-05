<?php


namespace App\HttpController;


use EasySwoole\Http\AbstractInterface\Controller;
use EasySwoole\Http\Message\Status;
use EasySwoole\WordsMatch\WordsMatchClient;

class WordsMatch extends Controller
{

    // 查找词
    function index()
    {
        // TODO: Implement index() method.
        $comment = $this->request()->getRequestParam('comment');
        if(empty($comment)){
            $this->writeJson(Status::CODE_BAD_REQUEST,null,'未提供comment参数或为空');
            return;
        }
        $result = WordsMatchClient::getInstance()->search($comment);
        $content = '未查到该词';
        if($result){
            $content = '查询到该词';
        }
        $this->writeJson(200,$result,$content);
    }

    // 移除词
    function remove()
    {
        $word = $this->request()->getRequestParam('word');
        WordsMatchClient::getInstance()->remove($word);

    }

    // 添加词
    function append()
    {
        $word = $this->request()->getRequestParam('word');
        $result = WordsMatchClient::getInstance()->append($word);
        $this->writeJson(200,$result,'添加词'.$word);
    }

    // 导出词
    function export()
    {
        $date = date('Y-m-d H:i');
        WordsMatchClient::getInstance()->export("export/{$date}-export.txt");
        $this->writeJson(200,null,'导出成功！');
    }

    // 导入词
    function import()
    {

    }

}