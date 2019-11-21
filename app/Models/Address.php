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
 * @property string $phone
 * @property string $details
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
}
