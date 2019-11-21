<?php

namespace App\Transformers;

use App\Models\Health;
use Illuminate\Support\Facades\DB;
use League\Fractal\TransformerAbstract;

class HealthTransformer extends TransformerAbstract
{
    public function transform(Health $health)
    {
        return [
            'birthday' => $health->birthday,
            'gender' => $health->gender == 'm' ? '男' : '女',
            'weight' => $health->weight,
            'height' => $health->height,
            'exercise' => DB::table('exercise')->find($health->exercise)->content,
            'purpose' => DB::table('purpose')->find($health->purpose)->content,
            'fat_rate' => $health->fat,
            'salt_rate' => $health->salt,
            'work_time' => $health->work_time . '-' . $health->rest_time,
        ];
    }
}
