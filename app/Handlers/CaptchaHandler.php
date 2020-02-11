<?php

namespace App\Handlers;

use Illuminate\Support\Facades\Cache;
use Overtrue\EasySms\EasySms;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;

class CaptchaHandler
{
    public function send(string $phone, string $content)
    {
        $easySms = new EasySms(config('sms'));

        try {
            $easySms->send($phone, [
                'content' => '您的验证码为：' . $content . '，三十分钟内有效，如非本人操作，请忽略本短信。'
            ]);
        } catch (NoGatewayAvailableException $e) {
            report($e);
            return false;
        }

        Cache::put('verify_phone:' . $phone, $content, 1800);
        return true;
    }

    public function verify($phone, $captcha)
    {
        if ($data = Cache::get('verify_phone:' . $phone))
        {
            if ($captcha == $data) {
                return true;
            }
        }
        return false;
    }
}
