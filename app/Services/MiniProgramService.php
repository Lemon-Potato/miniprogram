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

    /**
     * 微信小程序 登录接口
     * @param $code
     * @return mixed
     */
    public function code2Session($code)
    {
        $app = Factory::miniProgram(config('wechat.mini_program.default'));
        $res = $app->auth->session($code);
        return $res;
    }

}