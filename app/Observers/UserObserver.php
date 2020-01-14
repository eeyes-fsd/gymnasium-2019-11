<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Str;

class UserObserver
{
    /**
     * @param User $user
     */
    public function saving(User $user)
    {
        if (!$user->share_id)
        {
            $user->share_id = Str::uuid();
        }
    }
}
