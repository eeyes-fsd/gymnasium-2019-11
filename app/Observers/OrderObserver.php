<?php

namespace App\Observers;

use App\Handlers\AlgorithmHandler;
use App\Models\Order;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OrderObserver
{
    /**
     * @param Order $order
     */
    public function saving(Order $order)
    {
        if ($order->status === 1) {
            /** 如果订单包含食谱，添加至数据库 */
            if (!empty($order->details['recipes'])) {
                foreach ($order->details['recipes'] as $recipe) {
                    DB::table('recipe_user')->insert([
                        'user_id' => $order->user_id,
                        'recipe_id' => $recipe
                    ]);

                    $handler = new AlgorithmHandler();
                    $user = $order->user;

                    $diet = $handler->calculate_dist($user->health, Recipe::find($recipe));
                    $diet->save();
                }
            }

            //TODO 添加支付成功通知
        }
    }
}
