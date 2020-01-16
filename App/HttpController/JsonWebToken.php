<?php


namespace App\HttpController;


use EasySwoole\AtomicLimit\AtomicLimit;
use EasySwoole\Http\AbstractInterface\Controller;
use EasySwoole\Http\Message\Status;
use EasySwoole\Jwt\Jwt;
use EasySwoole\Policy\Policy;
use EasySwoole\Policy\PolicyNode;

class JsonWebToken extends Controller
{

    function index()
    {
        // TODO: Implement index() method.
        $jwtObject = Jwt::getInstance()
            ->setSecretKey('easyswoole') // 秘钥
            ->publish();

        $jwtObject->setAlg('HMACSHA256'); // 加密方式
        $jwtObject->setAud('user'); // 用户
        $jwtObject->setExp(time()+3600); // 过期时间
        $jwtObject->setIat(time()); // 发布时间
        $jwtObject->setIss('easyswoole'); // 发行人
        $jwtObject->setJti(md5(time())); // jwt id 用于标识该jwt
        $jwtObject->setNbf(time()+60*5); // 在此之前不可用
        $jwtObject->setSub('主题'); // 主题

        // 自定义数据
        $jwtObject->setData([
            'other_info'
        ]);

        // 最终生成的token
        $token = $jwtObject->__toString();

        $this->writeJson(Status::CODE_OK,null,$token);
    }

    function checkToken()
    {
        $policy = new Policy();
        //添加节点授权
        $policy->addPath('/user/add',PolicyNode::EFFECT_ALLOW);
        $policy->addPath('/user/update',PolicyNode::EFFECT_ALLOW);
        $policy->addPath('/user/delete',PolicyNode::EFFECT_DENY);
        $policy->addPath('/user/*',PolicyNode::EFFECT_DENY);

        //验证节点权限
        var_dump($policy->check('user/asdasd'));//deny
        var_dump($policy->check('user/add'));   //allow
        var_dump($policy->check('user/update'));//allow

        // 执行isAllow方法用来判断验证次数，并且原子计数器+1
        if(!AtomicLimit::isAllow('JsonWebToken')){
            $this->writeJson(status::CODE_EXPECTATION_FAILED,'JsonWebToken 5秒内超过5次');
            return;
        }

        $token = $this->request()->getRequestParam('token');
        try {
            // 如果encode设置了秘钥,decode 的时候要指定
            $jwtObject = Jwt::getInstance()->setSecretKey('easyswoole')->decode($token);

            $status = $jwtObject->getStatus();

            switch ($status)
            {
                case  1:
                    $code = Status::CODE_OK;
                    $msg = '验证通过';
                    $jwtObject->getAlg();
                    $jwtObject->getAud();
                    $jwtObject->getData();
                    $jwtObject->getExp();
                    $jwtObject->getIat();
                    $jwtObject->getIss();
                    $jwtObject->getNbf();
                    $jwtObject->getJti();
                    $jwtObject->getSub();
                    $jwtObject->getSignature();
                    $jwtObject->getProperty('alg');
                    break;
                case  -2:
                    $msg ='token过期';
                    $code = Status::CODE_EXPECTATION_FAILED;
                    break;
                default: //  -1:
                    $msg = '无效';
                    $code = Status::CODE_BAD_REQUEST;
                    break;
            }
        } catch (\EasySwoole\Jwt\Exception $e) {
            $msg = '异常';
            $code = Status::CODE_INTERNAL_SERVER_ERROR;
            $jwtObject = [];
        }

        $this->writeJson($code,$jwtObject,$msg);
    }

}