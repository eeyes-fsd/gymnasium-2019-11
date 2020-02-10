<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <title>注册</title>
</head>
<body>
<div id="app">
    {{ $user->name }}邀请你注册
    <form action="{{ app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('api.user.store') }}" method="post">
        <input type="tel" name="phone">
        <button v-on:click=" ">获取验证码</button>
        <input type="text" name="captcha">
        <input type="hidden" name="share_id" content="{{ $user->share_id }}">
    </form>
</div>

<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
