<?php

namespace App\Models;

/**
 * Class Address
 * @package App\Models
 *
 * @property int $id
 * @property int $user_id
 * @property User $user
 * @property string $name
 * @property string $gender 称呼
 * @property string $phone
 * @property string $street
 * @property string $details
 * @property \Illuminate\Database\Eloquent\Collection $orders
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Address extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'address_id0');
    }
}
