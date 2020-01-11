<?php


namespace App\HttpController;


use EasySwoole\Http\AbstractInterface\Controller;
use EasySwoole\Http\Message\Status;
use EasySwoole\Jwt\Jwt;

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

        /*$privat_key = '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';

        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImRhNWEyNDU2ODBjMzc0MDZhMGY2M2U3MTcwNTZkOWRlMzZhN2Q2NTk1NWMxNTc2YjgyMjg3MWU5N2YzZDUwZDI0OTU5NTJiYjJiN2M5NGE1In0.eyJhdWQiOiIxIiwianRpIjoiZGE1YTI0NTY4MGMzNzQwNmEwZjYzZTcxNzA1NmQ5ZGUzNmE3ZDY1OTU1YzE1NzZiODIyODcxZTk3ZjNkNTBkMjQ5NTk1MmJiMmI3Yzk0YTUiLCJpYXQiOjE1NzgwMzY5NzMsIm5iZiI6MTU3ODAzNjk3MywiZXhwIjoxNTc4NjQxNzczLCJzdWIiOiIyIiwic2NvcGVzIjpbIioiXX0.o1TXijPFYQhI0_kFsU2NKHwa2sgX-n3kFFyE2XmBuI_GFkdW3WThKZfbYJ3KqwRm1UqYM7lQje3VyB0GTOMe0ChAGNtrEVVmeEvQOCFcB6QsL-ULSIWDBZ9wZgXXDa10Yftq9q8HTBo6mSG52dKfvw58_4fQZUXRVPf5Y_GeeDWzWaZivYZCZwiSFYRgwXtMwDJJBrerxSrKJ23ad1VZWW2jqBCtjFdqQ6VzCd5q5cB3GGZG0IpY_xly81vGxuRJOBTt8PxuF3SNvKoibn1lafWb3Cuy6CuIm6C6UHuZdjAlOOqwKtcE3xTTHm9HRbkSkOPlpvsmOFPIb2tCuzZJGnN_RZtmDfh0mt-NS0WuQ8_vnowna4aZ5zoGhz-eezYz4tJEIL2LNviPkp6cdzUo65fc9szHDIflTcsIe7VhTf5ILfoQBxKTXAKPXmcQ6uYeS6Xr99SfJxa7wMHuA2zpDZFZi_60RMWeV2iJen9pXGJmTfoJJdCbt9qdjiNzGFsdOg1tooZsW6JDrRYOWngjIVju7yuHqiKHg1okAbCFkpz5UXprAf_8Mw9FV5mFCeSelPnlTdZmUITJZw4GaqfXRiZnQY_nmhxEd5Z5EtnYQF2kToy6YCr1B22d1u5f2LxmG7DdCGoraqJHFd2JLe7X0emalXGlffTYvmcxtVaBqkw';

        $jwt = Jwt::getInstance();
        $jwt = $jwt->setSecretKey($privat_key);
        $jwtObject = $jwt->decode($token);
        var_dump($jwtObject);*/

        $this->writeJson(Status::CODE_OK,null,$token);
    }
}