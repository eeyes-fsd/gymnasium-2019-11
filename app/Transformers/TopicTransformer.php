<?php

namespace App\Transformers;

use App\Models\Topic;
use League\Fractal\TransformerAbstract;

class TopicTransformer extends TransformerAbstract
{
    private $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function transform(Topic $topic)
    {
        switch ($this->type) {
            case 'item':
                return [
                    'id' => $topic->id,
                    'title' => $topic->title,
                    'body' => $topic->body,
                    'created_at' => $topic->created_at->toDateTimeString(),
                    'updated_at' => $topic->updated_at->toDateTimeString(),
                ];
                break;
            case 'collection':
                return [
                    'id' => $topic->id,
                    'title' => $topic->title,
                    'short' => $topic->short,
                    'created_at' => $topic->created_at->toDateTimeString(),
                    'updated_at' => $topic->updated_at->toDateTimeString(),
                ];
                break;
        }
    }
}
