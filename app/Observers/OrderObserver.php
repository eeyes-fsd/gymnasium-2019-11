<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Recipe;
use App\Handlers\AlgorithmHandler;
use App\Notifications\OrderCanceled;
use App\Notifications\OrderPaid;
use App\Notifications\OrderDelivering;
use App\Notifications\OrderFinished;
use Illuminate\Support\Facades\DB;

class OrderObserver
{
    /**
     * @param Order $order
     */
    public function saving(Order $order)
    {
        switch ($order->status) {
            case -1:
                $order->user->notify(new OrderCanceled($order));
                break;

            /** 如果订单包含食谱，添加至数据库 */
            case 1:
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

                $order->user->notify(new OrderPaid($order));
                break;

            case 2:
                $order->user->notify(new OrderDelivering($order));
                break;

            case 3:
                $order->user->notify(new OrderFinished($order));
                break;
        }
    }
}
