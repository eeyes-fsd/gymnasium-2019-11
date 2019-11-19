<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthorizationsController extends Controller
{
    /**
     * @param Request $request
     * @return mixed|void
     */
    public function socialStore(Request $request)
    {
        $code = $request->code;
        $miniProgram = \EasyWeChat::miniProgram();
        $response = $miniProgram->auth->session($code);

        if (isset($data['errcode'])) {
            return $this->response->errorUnauthorized('code 错误');
        }

        if (!$user = User::where('wx_openid', $response['openid'])->first()) {
            $user = User::create([
                'name' => 'wx_user_' . Str::random(8),
                'password' => '*',
                'wx_openid' => $response['openid'],
                'wx_session_key' => $response['session_key'],
            ]);
        }

        $token = Auth::guard('api')->fromUser($user);
        return $this->responseWithToken($token);
    }

    /**
     * @return mixed
     */
    public function update()
    {
        $token = Auth::guard('api')->refresh();
        return $this->responseWithToken($token);
    }

    /**
     * @param string $token
     * @return mixed
     */
    public function responseWithToken(string $token)
    {
        return $this->response->array([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }
}
