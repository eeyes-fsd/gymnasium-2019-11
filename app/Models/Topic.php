<?php

namespace App\Models;

/**
 * Class Topic
 * @package App\Models
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string short
 * @property string $body
 * @property User $user
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Topic extends Model
{
    /**
     * 定义话题与用户从属关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
