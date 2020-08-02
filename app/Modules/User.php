<?php

namespace App\Modules;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['openid', 'session_key', 'name', 'email', 'password', 'avatar_url', 'unionid'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 微信登录时候创建新的用户
     * @param $info
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function createUser($info)
    {
        try {
            $user = self::query()->firstOrCreate(['openid'=>$info['openid']], [
                'openid'=>$info['openid'],
                'session_key'=>$info['session_key'],
                'name'=>'','email'=>'','password'=>'','avatar_url'=>'','unionid'=>''
            ]);

            if ($user) {
                $user->session_key = $info['session_key'];
                $user->save();
            }
            return $user->id;
        } catch (\Exception $exception) {
            Log::error('新创建用户失败'. $exception->getMessage() . $exception->getTraceAsString());
        }

    }

}
