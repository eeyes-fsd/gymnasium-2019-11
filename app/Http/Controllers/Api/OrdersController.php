<?php

namespace App\Http\Controllers\Api;

use App\Handlers\AddressHandler;
use App\Handlers\AlgorithmHandler;
use App\Models\Address;
use App\Models\Diet;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\Variable;
use App\Notifications\OrderPaid;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
     * @return array
     */
    private function calculate_cost(array $diet_, bool $cook=false)
    {
        $fee = 0; $weight = 0;

        $diet_recipe = Recipe::findOrFail($diet_['id']);
        if (!$diet = Diet::where('recipe_id', $diet_recipe->id)->where('user_id', Auth::id())->first()) {
            $handler = new AlgorithmHandler();
            if (!$health = Auth::guard('api')->user()->health) {
                $diet = new Diet();
                foreach (['breakfast', 'lunch', 'dinner'] as $item) {
                    $temp = [];
                    foreach ($diet_recipe->$item as $ingredient) {
                        $temp[] = [
                            'id' => $ingredient['id'],
                            'amount' => $ingredient['min'],
                        ];
                        $diet->$item = $temp;
                    }
                }
            } else $diet = $handler->calculate_dist($health, $diet_recipe);
        }

        foreach (['breakfast', 'lunch', 'dinner'] as $name) {
            foreach ($diet->$name as $item) {
                $ingredient = Ingredient::find($item['id']);
                $fee += $ingredient->price * $item['amount'];
                $weight += $item['amount'];
            }
            $fee += $cook ? $diet_recipe->cook_cost : 0;
        }

        return array($fee * $diet_['amount'], $weight * $diet_['amount']);
    }

    /**
     * @param OrderRequest $request
     * @throws \Exception
     * @return \Dingo\Api\Http\Response
     */
    public function store(OrderRequest $request)
    {
        $order_id = Uuid::uuid1();
        $fee = 0; $details = []; $deliver = false; $weight = 0;
        $discount = Variable::where('name', 'recipe_discount')->first()->content;
        // 准备免费送食谱数据
        $free_recipes = [];
        if ($discount['free']) $free_recipes = array_merge($request->diets, $request->ingredients);

        foreach ($request->recipes as $recipe_) {
            if ($recipe_ == 0) {
                $recipes = Recipe::all();
                foreach ($recipes as $r) {
                    if (Auth::guard('api')->user()->has_recipe($r)) {
                        continue;
                    }
                    if ($discount['free'] && in_array($recipe_, $free_recipes)) {
                        continue;
                    }
                    $details['recipes'][] = $r->id;
                    $fee += $r->price;
                }
                break;
            }

            $recipe = Recipe::findOrFail($recipe_);
            if (Auth::guard('api')->user()->has_recipe($recipe)) {
                continue;
            }
            if ($discount['free'] && in_array($recipe_, $free_recipes)) {
                continue;
            }
            $details['recipes'][] = $recipe_;
            $fee += $recipe->price;
        }

        if (count($details['recipes']) >= 3) {
            $fee *= $discount[3];
        }
        if ($request->recipes[0] == 0) {
            $fee *= $discount['all'];
        }

        foreach ($request->diets as $diet_) {
            $deliver = true;
            $t = $this->calculate_cost($diet_, true);
            $fee += $t[0];
            $weight += $t[1];
            $diet_['cost'] = $t[0];
            $details['meals'][] = $diet_;
        }

        foreach ($request->ingredients as $ingredient_) {
            $deliver = true;
            $t = $this->calculate_cost($ingredient_);
            $fee += $t[0];
            $weight += $t[1];
            $ingredient_['cost'] = $t[0];
            $details['ingredients'][] = $ingredient_;
        }

        if ($deliver) {
            // 准备计算数据
            $deliver_fee = DB::table('deliver_fee')->get();
            $weight_fee = DB::table('weight_fee')->get();
            $time_fee = DB::table('time_fee')->get();
            $fee += 10;

            // 检查地址
            if (!$address = Address::find($request->address_id)) abort(404, '地址未找到');

            // 计算距离，检查可用性
            $distance = AddressHandler::calculate_distance($address);
            $service_id = $distance[0]; $distance = $distance[1];
            if ($distance < $deliver_fee[0]->lb || $distance > $deliver_fee->last()->ub) abort(400, '无效地址');

            // 计算距离附加费
            $calculated = 0;
            foreach ($deliver_fee as $item) {
                if ($distance > $item->lb) {
                    if ($distance <= $item->ub) {
                        $fee += ($distance - $calculated) * $item->fee;
                        break;
                    } else {
                        $length = $item->ub - $item->lb;
                        $fee += $item->fee * $length;
                        $calculated += $length;
                    }
                }
            }

            // 计算重量附加费
            $weight /= 1000;
            foreach ($weight_fee as $item) {
                if ($weight > $item->lb && $weight <= $item->ub) {
                    $fee += $item->fee;
                }
            }

            // 计算时间附加费
            $deliver_at = Carbon::parse($request->deliver_at)->hour;
            foreach ($time_fee as $item) {
                if ($deliver_at > $item->lb && $deliver_at <= $item->ub) {
                    $fee += $item->fee;
                }
            }
        }

        $order = Order::create([
            'id' => $order_id,
            'user_id' => Auth::id(),
            'details' => $details,
            'service_id' => $service_id ?? null,
            'fee' => $fee,
            'address_id' => $request->address_id,
            'deliver_at' => $request->deliver_at ? Carbon::createFromFormat('Y-m-d\TH:i:s', $request->deliver_at) : Carbon::now(),
            'status' => '0'
        ]);

        return $this->response->created(app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('api.orders.update', [$order_id, 'pay']));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function callback(Request $request)
    {
        $payment = \EasyWeChat::payment();

        $response = $payment->handlePaidNotify(function ($message, $fail) use ($payment) {
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

        return $response;
    }

    /**
     * @param Order $order
     * @param string $action
     * @return \Dingo\Api\Http\Response|void
     */
    public function update(Order $order, string $action)
    {
        if (Auth::id() != $order->user_id) return $this->response->errorForbidden('不是您的订单');
        switch ($action) {
            case 'pay':
                if ($order->status == 1) return $this->response->errorBadRequest('订单已支付');
                $payment = \EasyWeChat::payment();
                $pay_info = [
                    'body' => '秤食-食谱购买',
                    'out_trade_no' => $order->id,
                    'total_fee' => $order->fee,
                    'sign_type' => 'MD5',
                    'notify_url' => app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('api.orders.callback'),
                    'trade_type' => 'JSAPI',
                ];

                $result = $payment->order->unify($pay_info);

                if (isset($result['errno'])) {
                    return $this->response->errorInternal('支付接口调用失败，请联系管理员');
                }

                Auth::guard('api')->user()->notify(new OrderPaid($order));

                return $this->response->array([
                    'nonce_str' => $result['nonce_str'],
                    'prepay_id' => $result['prepay_id'],
                ]);

                break;

            case 'cancel':
                $attributes = array('status' => -1);

                if ($order->status == 1) {
                    $refund = Str::uuid()->toString();
                    $payment = \EasyWeChat::payment();
                    $payment->refund->byOutTradeNumber($order->id, $refund, $order->fee);
                    $attributes['refund_no'] = $refund;
                }

                $order->update($attributes);


                return $this->response->noContent();

                break;

            default:
                return $this->response->errorBadRequest('不支持的操作');
        }
    }
}
