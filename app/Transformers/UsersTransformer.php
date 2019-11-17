<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UsersTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'sex' => $user->sex,
            'birthday' => $user->birthday,
            'height' => $user->height,
            'weight' => $user->weight,
        ];
    }
}