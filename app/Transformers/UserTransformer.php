<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'phone' => $user->phone,
            'share_id' => $user->share_id,
            'share_url' => route('register') . '?share_id=' . $user->share_id,
            'qr_code' => url('storage/qr-code/' . $user->share_id . '.png')
        ];
    }
}
