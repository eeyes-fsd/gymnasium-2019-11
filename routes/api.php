<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => 'bindings'
], function ($api) {
    /** 认证接口 */
    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.throttling.sign.limit'),
        'expires' => config('api.throttling.sign.expires')
    ], function ($api) {
        // 微信小程序登录
        $api->post('authorizations/weapp', 'AuthorizationsController@socialStore')
            ->name('api.authorizations.weapp.store');

        // 刷新 Token
        $api->put('authorizations/current', 'AuthorizationsController@update')
            ->name('api.authorizations.update');
    });

    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.throttling.access.limit'),
        'expires' => config('api.throttling.access.expires')
    ], function ($api) {
        /** 无需认证的接口 */

        $api->group([
            'middleware' => 'api.auth',
        ], function ($api) {
            /** 需要认证的接口 */

            // 用户路由
            $api->get('user', 'UsersController@show')
                ->name('api.user.show');
            $api->put('user', 'UsersController@update')
                ->name('api.user.update');
            $api->delete('user', 'UsersController@destroy')
                ->name('api.user.destroy');
        });
    });
});
