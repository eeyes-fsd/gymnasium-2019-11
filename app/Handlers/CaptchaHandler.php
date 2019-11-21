<?php

namespace App\Handlers;

use Illuminate\Support\Facades\Cache;
use Overtrue\EasySms\EasySms;

class CaptchaHandler
{
    public function send(string $phone, string $content, $id)
    {
        $easySms = new EasySms(config('sms'));
        $easySms->send($phone, [
            'content' => '您的验证码为：' . $content . '，三十分钟内有效，如非本人操作，请忽略本短信。'
        ]);

        Cache::put('verify_phone:' . $id, $phone . $content, 1800);

        return true;
    }
}
