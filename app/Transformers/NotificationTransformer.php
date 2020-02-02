<?php

namespace App\Transformers;

use Illuminate\Support\Str;
use League\Fractal\TransformerAbstract;

class NotificationTransformer extends TransformerAbstract
{
    /**
     * @param \Illuminate\Notifications\DatabaseNotification $notification
     * @return mixed
     */
    public function transform($notification)
    {
        return [
            'id' => $notification->id,
            'type' => Str::snake(class_basename($notification->type)),
            'content' => $notification->data,
            'created_at' => $notification->created_at,
        ];
    }
}
