<?php

namespace App\Models;

/**
 * Class Order
 * @package App\Models
 *
 * @property string $id
 * @property int $fee
 * @property int $status
 * @property array $details
 * @property int $user_id
 * @property int $service_id
 * @property int $address_id
 * @property User $user
 * @property Service $service
 * @property Address $address
 * @property \Illuminate\Support\Carbon $deliver_at
 */
class Order extends Model
{
    protected $keyType = 'string';
    protected $guarded = ['created_at', 'updated_at'];
    protected $dates = [
        'deliver_at',
    ];

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address()
    {
        return $this->belongsTo('App\Models\Address', 'address_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo('App\Models\Service', 'service_id');
    }
}
