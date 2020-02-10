<?php

namespace App\Models;

/**
 * Class Image
 * @package App\Models
 *
 * @property int $user_id
 * @property User $user
 * @property string $path
 */
class Image extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
