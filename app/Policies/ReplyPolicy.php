<?php

namespace App\Policies;

use App\Models\Reply;
use App\Models\User;

class ReplyPolicy extends Policy
{
    /**
     * @param User $user
     * @param Reply $reply
     * @return bool
     */
    public function delete(User $user, Reply $reply)
    {
        return $user->id === $reply->user_id;
    }
}
