<?php
/**
 * Created by PhpStorm.
 * User: lemon
 * Date: 2020/8/2
 * Time: 10:11 PM
 */

namespace App\Services;

class JWTService
{
    public function login($data, $user_id){
        if($token = auth('api')->claims(['user_id'=>$user_id])->login($data)){
            return $this->respondWithToken($token);
        }
        return ['error'=>'Unauthorized'];
    }

    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ];
    }
}