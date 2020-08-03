<?php

namespace App\Modules;

use App\Services\JWTService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
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
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * 微信登录时候创建新的用户
     * @param $info
     * @return array
     */
    public function createUser($info)
    {
        $jwt_auth_service = new JWTService();

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

            $res = $jwt_auth_service->login($user, 2);
            $res['user_id'] = $user->id;
            return $res;
        } catch (\Exception $exception) {
            Log::error('新创建用户失败'. $exception->getMessage() . $exception->getTraceAsString());
        }

    }

    public function updateUserByOpenId($info)
    {
        try {
            $user = self::query()->where('openid', $info['openId'])->first();
            $user->name = $info['nickName'];
            $user->avatar_url = $info['avatarUrl'];
            $user->save();
        } catch (\Exception $exception) {
            Log::error('微信用户更新数据失败'. $exception->getMessage() . $exception->getTraceAsString());
        }

    }

}
