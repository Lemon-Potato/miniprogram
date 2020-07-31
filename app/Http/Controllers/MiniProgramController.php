<?php

namespace App\Http\Controllers;

use App\Services\MiniProgramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MiniProgramController extends Controller
{
    public function login(Request $request)
    {
        $code = $request->input('code');
        $mini_program_service = new MiniProgramService();
        $res = $mini_program_service->code2Session($code);
        Log::info('微信小程序登录返回参数', $res);
        return responseSuccess();
    }
}
