<?php
/**
 * Created by PhpStorm.
 * User: lemon
 * Date: 2020/7/31
 * Time: 11:04 PM
 */
namespace App\Services;


use EasyWeChat\Factory;

class MiniProgramService
{

    protected $app = null;

    public function __construct()
    {
        $this->app = Factory::miniProgram(config('wechat.mini_program.default'));
    }

    /**
     * 微信小程序 登录接口
     * @param $code
     * @return mixed
     */
    public function code2Session($code)
    {
        $res = $this->app->auth->session($code);
        return $res;
    }

    /**
     * 微信小程序 消息解密
     * @param $session
     * @param $iv
     * @param $encryptedData
     * @return array
     */
    public function decryotedData($session, $iv, $encryptedData)
    {
        $res = $this->app->encryptor->decryptData($session, $iv, $encryptedData);
        return $res;
    }

}