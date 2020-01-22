<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Ramsey\Uuid\Uuid;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Transformers\OrderTransformer;
use App\Http\Requests\Api\OrderRequest;

class OrdersController extends Controller
{
    public function index()
    {
        $user_id = Auth::guard('api')->id();
        $orders = Order::where('user_id', $user_id)->get();

        return $this->response->collection($orders, new OrderTransformer());
    }

    public function show(Order $order)
    {
        return $this->response->item($order, new OrderTransformer());
    }

    /**
     * @param OrderRequest $request
     * @throws \Exception
     */
    public function store(OrderRequest $request)
    {
        $payment = \EasyWeChat::payment();
        $order_id = Uuid::uuid1();
        $recipes = $request->recipes;
        $dites=$request->dites;
        $ingredients=$request->ingredients;
        $fee = 0; $details = [];

        foreach ($recipes as $id) {
            $recipe = Recipe::findOrFail($id);
            $details[] = $id;
            $fee += $recipe->price;//算钱
        }
        foreach ($dites as $amount) {
            $dite = Dite::findOrFail($amount);
            $fee += $dite->process_cost*$amount;//算钱
        }
        foreach ($ingredients as $amount) {
            $ingredient = Ingredient::findOrFail($amount);
            $fee += $ingredient->ingredient_cost*$amount;//算钱
        }
            $fee+=$express_fee;

        Order::create([
            'id' => $order_id,
            'user_id' => Auth::id(),
            'details' => $details,
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
