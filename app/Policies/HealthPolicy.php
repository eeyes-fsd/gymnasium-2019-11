<?php

namespace App\Policies;

use App\Models\Health;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class HealthPolicy extends Policy
{
    /**
     * @param User $user
     * @param Health $health
     * @return bool
     */
    public function show(User $user, Health $health)
    {
        return $user->id === $health->user_id;
    }

    /**
     * @param User $user
     * @param Health $health
     * @return bool
     */
    public function update(User $user, Health $health)
    {
        return $user->id === $health->user_id;
    }
}
