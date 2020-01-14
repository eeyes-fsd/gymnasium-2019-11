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
            'exercise' => DB::table('exercises')->find($health->exercise)->content,
            'purpose' => DB::table('purposes')->find($health->purpose)->content,
            'habit' => DB::table('habits')->find($health->habit)->content,
            'fat_rate' => $health->fat,
        ];
    }
}
