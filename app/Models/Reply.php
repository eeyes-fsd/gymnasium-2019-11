<?php

namespace App\Models;

/**
 * Class Reply
 * @package App\Models
 *
 * @property string $content
 * @property int $user_id
 * @property int $topic_id
 * @property User $user
 * @property Topic $topic
 */
class Reply extends Model
{
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
    public function topic()
    {
        return $this->belongsTo('App\Models\Topic', 'topic_id');
    }
}
