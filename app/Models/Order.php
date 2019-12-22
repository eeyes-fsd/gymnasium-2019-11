<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * @package App\Models
 *
 * @property string $id
 * @property array $details
 * @property int $user_id
 * @property User $user
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Order extends Model
{
    protected $keyType = 'string';
    protected $guarded = ['created_at', 'updated_at'];

    /**
     * @param array $details
     */
    public function setDetailsAttribute(array $details)
    {
        $this->attributes['details'] = serialize($details);
    }

    /**
     * @param $details
     * @return mixed
     */
    public function getDetailsAttribute($details)
    {
        return unserialize($details);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
