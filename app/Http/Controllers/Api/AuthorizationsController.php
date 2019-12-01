<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        $phone_user_exists = false;
        $openid_user_exists = false;

        if ($user = User::where('phone', $request->phone)->first()) $phone_user_exists = true;

        dd($user);

        $miniProgram = \EasyWeChat::miniProgram();
        $response = $miniProgram->auth->session($code);

        if (isset($data['errcode'])) {
            return $this->response->errorUnauthorized('code 错误');
        }

        if ($user = User::where('wx_openid', $response['openid'])->first()) $openid_user_exists = true;

        if ($phone_user_exists) {
            if ($openid_user_exists) {
                //Do Nothing
            } else {
                $user->update([
                    'wx_openid' => $response['openid'],
                    'wx_session_key' => $response['session_key']
                ]);
            }
        } else {
            if ($openid_user_exists) {
                $user->update([
                    'phone' => $request->phone,
                ]);
            } else {
                $user = User::create([
                    'name' => 'wx_user_' . Str::random(8),
                    'phone' => $request->phone,
                    'password' => '*',
                    'wx_openid' => $response['openid'],
                    'wx_session_key' => $response['session_key']
                ]);
            }
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
