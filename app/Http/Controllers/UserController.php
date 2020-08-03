<?php
/**
 * Created by PhpStorm.
 * User: lemon
 * Date: 2020/8/2
 * Time: 11:36 AM
 */

namespace App\Http\Controllers;


use App\Modules\User;
use Illuminate\Http\Request;
use App\Services\MiniProgramService;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{

    public function updateUser(Request $request)
    {
        $user_model = new User();
        $param = $request->all();
        $user = User::query()->find($param['userId']);
        $session = $user->session_key;
        $mini_program_service = new MiniProgramService();
        $decryted_info = $mini_program_service->decryotedData($session, $param['iv'], $param['encryptedData']);
        Log::info('微信小程序解密数据', $decryted_info);
        $user_model->updateUserByOpenId($decryted_info);
        return responseSuccess();
    }

    public function test(Request $request)
    {
        $res = JWTAuth::parseToken()->payload();
        return responseSuccess($res);
    }

}