<?php

namespace App\Transformers;

use App\Models\Health;
use League\Fractal\TransformerAbstract;

class HealthTransformer extends TransformerAbstract
{
    public function transform(Health $health)
    {
        return [
            'age' => $health->age,
            'gender' => $health->gender == 'm' ? '男' : '女',
            'weight' => $health->weight,
            'height' => $health->height,
        ];
    }
}
