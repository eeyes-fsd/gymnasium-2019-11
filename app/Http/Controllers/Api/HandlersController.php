<?php

namespace App\Http\Controllers\Api;

use App\Handlers\CaptchaHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;

class HandlersController extends Controller
{
    /**
     * @param Request $request
     * @param CaptchaHandler $handler
     * @return \Dingo\Api\Http\Response|void
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function verify_phone(Request $request, CaptchaHandler $handler)
    {
        $this->validate($request, [
            'phone' => [
                'required',
                'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199|(147))\d{8}$/',
            ]
        ]);

        $captcha = random_int(10000, 99999);
        try{
            $handler->send($request->phone, $captcha, Auth::guard('api')->id());
        } catch (NoGatewayAvailableException $e)
        {
            report($e);
            return $this->response->errorInternal('短信发送失败');
        }

        return $this->response->created();
    }
}
