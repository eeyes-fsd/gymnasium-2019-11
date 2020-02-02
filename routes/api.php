<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => 'bindings'
], function (\Dingo\Api\Routing\Router $api) {
    /** 认证接口 */
    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.throttling.sign.limit'),
        'expires' => config('api.throttling.sign.expires')
    ], function (\Dingo\Api\Routing\Router $api) {
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
    ], function (\Dingo\Api\Routing\Router $api) {
        /** 无需认证的接口 */
        $api->post('user', 'UsersController@store')
            ->name('api.user.store');
        $api->post('phone_verify', 'HandlersController@verify_phone')
            ->name('api.phone.verify');

        $api->get('exercises', function () {
            return \Illuminate\Support\Facades\DB::table('exercises')->get();
        });
        $api->get('purposes', function () {
            return \Illuminate\Support\Facades\DB::table('purposes')->get();
        });
        $api->get('habits', function () {
            return \Illuminate\Support\Facades\DB::table('habits')->get();
        });

        $api->post('order/callback', 'OrdersController@callback')
            ->name('api.orders.callback');

        $api->get('topics', 'TopicsController@index')
            ->name('api.topics.index');
        $api->get('topics/{topic}', 'TopicsController@show')
            ->name('api.topics.show');

        //套餐路由
        $api->get('recipes/{type?}', 'RecipesController@index')
            ->name('api.recipes.index');
        $api->get('recipes/{recipe}/briefs', 'RecipesController@show2')
            ->name('api.recipes.briefs');

        $api->get('diets', 'DietsController@index')
            ->name('api.diets.index');

        $api->get('topics/{topic}/replies', 'RepliesController@index')
            ->name('api.replies.topic');

        $api->group([
            'middleware' => 'api.auth',
        ], function (\Dingo\Api\Routing\Router $api) {
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

            // 身体信息路由
            $api->get('health/{detail?}', 'HealthController@show')
                ->name('api.health.show');
            $api->post('health', 'HealthController@store')
                ->name('api.health.store');
            $api->put('health', 'HealthController@update')
                ->name('api.health.update');

            //订单接口
            $api->get('orders', 'OrdersController@index')
                ->name('api.orders.index');
            $api->get('orders/{order}', 'OrdersController@show')
                ->name('api.orders.show');
            $api->patch('orders/{order}/{action}', 'OrdersController@update')
                ->name('api.orders.update');
            $api->post('orders', 'OrdersController@store')
                ->name('api.orders.store');

            $api->post('topics', 'TopicsController@store')
                ->name('api.topics.store');
            $api->put('topics/{topic}', 'TopicsController@update')
                ->name('api.topics.update');
            $api->delete('topics/{topic}', 'TopicsController@destroy')
                ->name('api.topics.delete');

            $api->get('diets/{recipe}', 'DietsController@show')
                ->name('api.diets.show');

            $api->get('recipes/{recipe}/details', 'RecipesController@show')
                ->name('api.recipes.details');

            $api->get('notifications', 'NotificationsController@index')
                ->name('api.notifications.index');
            $api->get('notifications/stats', 'NotificationsController@stats')
                ->name('api.notifications.stats');
            $api->patch('notifications/read', 'NotificationsController@read')
                ->name('api.notifications.read');

            $api->get('user/replies', 'RepliesController@index2')
                ->name('api.replies.user');
            $api->post('topics/{topic}/replies', 'RepliesController@store')
                ->name('api.replies.topic');
            $api->delete('replies/{reply}', 'RepliesController@destroy')
                ->name('api.replies.destroy');
        });
    });
});
