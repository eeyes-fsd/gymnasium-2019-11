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

            // 地址路由
            $api->get('addresses', 'AddressesController@index')
                ->name('api.addresses.index');
            $api->get('addresses/{address}', 'AddressesController@show')
                ->name('api.addresses.show');
            $api->post('addresses', 'AddressesController@store')
                ->name('api.addresses.store');
            $api->put('addresses/{address}', 'AddressesController@update')
                ->name('api.addresses.update');
            $api->delete('addresses/{address}', 'AddressesController@destroy')
                ->name('api.addresses.destroy');

            // 身体信息接口
            $api->get('health', 'HealthController@show')
                ->name('api.health.show');
            $api->post('health', 'HealthController@store')
                ->name('api.health.store');
            $api->put('health', 'HealthController@update')
                ->name('api.health.update');
        });
    });
});
