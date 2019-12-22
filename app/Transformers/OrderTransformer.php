<?php

namespace App\Transformers;

use App\Models\Order;
use League\Fractal\TransformerAbstract;

class OrderTransformer extends TransformerAbstract
{
    public function transform(Order $order)
    {
        return [
            'id' => $order->id,
            'details' => $order->details,
            'created_at' => $order->created_at->toDateTimeString(),
            'updated_at' => $order->updated_at->toDateTimeString(),
        ];
    }
}
