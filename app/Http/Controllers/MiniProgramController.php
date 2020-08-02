<?php

namespace App\Http\Controllers;

use App\Modules\User;
use App\Services\MiniProgramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MiniProgramController extends Controller
{
    public function login(Request $request)
    {
        $user_model = new User();
        $code = $request->input('code');
        $mini_program_service = new MiniProgramService();
        $login_info = $mini_program_service->code2Session($code);
        Log::info('微信小程序登录返回参数', $login_info);
        $user_id = $user_model->createUser($login_info);
        return responseSuccess($user_id);
    }
}
