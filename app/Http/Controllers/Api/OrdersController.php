<?php

namespace App\Http\Controllers\Api;

use App\Models\Diet;
use App\Models\Ingredient;
use App\Models\Order;
use Ramsey\Uuid\Uuid;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Transformers\OrderTransformer;
use App\Http\Requests\Api\OrderRequest;

class OrdersController extends Controller
{
    /**
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $user_id = Auth::guard('api')->id();
        $orders = Order::where('user_id', $user_id)->get();

        return $this->response->collection($orders, new OrderTransformer());
    }

    /**
     * @param Order $order
     * @return \Dingo\Api\Http\Response
     */
    public function show(Order $order)
    {
        return $this->response->item($order, new OrderTransformer());
    }

    /**
     * @param array $diet_
     * @param bool $cook
     * @return int
     */
    private function calculate_cost(array $diet_, bool $cook=false)
    {
        $fee = 0;

        $diet_recipe = Recipe::findOrFail($diet_['id']);
        if (!$diet = Diet::where('recipe_id', $diet_recipe->id)->where('user_id', Auth::id())->first()) {
            $handler = new \App\Handlers\AlgorithmHandler();
            $result = $handler->calculate_dist(Auth::guard('api')->user()->health, $diet_recipe);
            $diet = $result;
        }

        foreach (['breakfast', 'lunch', 'dinner'] as $name) {
            foreach ($diet->$name as $item) {
                $ingredient = Ingredient::find($item['id']);
                $fee += $ingredient->price * $item['amount'];
            }
            $fee += $diet_recipe->cook_cost;
        }

        return $fee;
    }

    /**
     * @param OrderRequest $request
     * @throws \Exception
     */
    public function store(OrderRequest $request)
    {
        $payment = \EasyWeChat::payment();
        $order_id = Uuid::uuid1();
        $fee = 0; $details = []; $deliver = false;

        foreach ($request->recipes as $recipe_) {
            $recipe = Recipe::findOrFail($recipe_['id']);
            $details['recipes'] = $recipe_['id'];
            $fee += $recipe->price;
        }

        foreach ($request->diets as $diet_) {
            $deliver = true;
            $fee += $this->calculate_cost($diet_, true);
            $details['meals'] = $diet_;
        }

        foreach ($request->ingredients as $ingredient_) {
            $deliver = true;
            $fee += $this->calculate_cost($ingredient_);
            $details['ingredients'] = $ingredient_;
        }

        //TODO 添加运费计算
        //if ($deliver) $fee += ;

        Order::create([
            'id' => $order_id,
            'user_id' => Auth::id(),
            'details' => $details,
            'address_id' => $request->address_id,
            'status' => '0'
        ]);

        $pay_info = [
            'body' => '秤食-食谱购买',
            'out_trade_no' => $order_id->toString(),
            'total_fee' => $fee,
            'notify_url' => app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('api.orders.callback', $order_id->toString()),
            'trade_type' => 'JSAPI',
        ];
        
        $result = $payment->order->unify($pay_info);
        if (isset($result['errno'])) {
            return $this->response->errorInternal('支付接口调用失败，请联系管理员');
        }

        return $this->response->array([
            'nonce_str' => $result['nonce_str'],
            'prepay_id' => $result['prepay_id'],
        ]);
    }

    public function callback(Request $request)
    {
        $payment = \EasyWeChat::payment();

        $payment->handlePaidNotify(function ($message, $fail) use ($payment){
            if (!$order = Order::find($message['out_trade_no'])) {
                return true;
            }

            if ($message['return_code'] === 'SUCCESS') {
                if ($message['result_code'] === "SUCCESS") {
                    $order->status = 1;
                } elseif ($message['result_code'] === "FAIL") {
                    $order->status = -1;
                    $payment->order->close($order->id);
                }
            } else {
                return $fail("通信失败");
            }

            $order->save();

            return true;
        });
    }
}
