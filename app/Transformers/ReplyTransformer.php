<?php

namespace App\Transformers;

use App\Models\Reply;
use League\Fractal\TransformerAbstract;

class ReplyTransformer extends TransformerAbstract
{
    /**
     * @param Reply $reply
     * @return array
     */
    public function transform(Reply $reply)
    {
        return [
            'id' => $reply->id,
            'topic_id' => $reply->topic_id,
            'content' => $reply->content,
            'created_at' => $reply->created_at->diffForHumans(),
            'updated_at' => $reply->updated_at->diffForHumans(),
        ];
    }
}
