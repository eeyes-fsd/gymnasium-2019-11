<?php

use Illuminate\Http\Request;
$api = app('Dingo\Api\Routing\Router');


$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => 'bindings'
], function ($api) {

    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.access.limit'),
        'expires' => config('api.rate_limits.access.expires')
    ], function ($api) {

        //用户路由
        $api->get('user', 'UsersController@show')
            ->name('api.user.show');

        $api->put('user', 'UsersController@update')
            ->name('api.user.update');
        $api->delete('user', 'UsersController@destroy')
            ->name('api.user.destroy');
    });
});
