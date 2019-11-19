<?php

namespace App\Models;

/**
 * Class Health
 * @package App\Models
 *
 * @property int $id
 * @property int $user_id
 * @property User $user
 * @property int $age
 * @property string $gender
 * @property float $weight
 * @property int $height
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Health extends Model
{
    /**
     * 定义身体状况与用户的关联关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
