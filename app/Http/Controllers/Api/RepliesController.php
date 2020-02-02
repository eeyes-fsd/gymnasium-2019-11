<?php

namespace App\Http\Controllers\Api;

use App\Models\Reply;
use App\Models\Topic;
use App\Transformers\ReplyTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepliesController extends Controller
{
    public function index(Topic $topic)
    {
        $replies = $topic->replies;
        return $this->response->collection($replies, new ReplyTransformer());
    }

    public function index2()
    {
        /** @var \App\Models\User $user */
        $user = Auth::guard('api')->user();

        $replies = $user->replies;
        return $this->response->collection($replies, new ReplyTransformer());
    }

    /**
     * @param Topic $topic
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(Topic $topic, Request $request)
    {
        $reply = new Reply();
        $reply->topic()->associate($topic);
        $reply->user()->associate(Auth::guard('api')->user());

        $reply->content = $request->post('content');
        $reply->save();

        return $this->response->created();
    }

    /**
     * @param Reply $reply
     * @return \Dingo\Api\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('delete', $reply);

        return $this->response->noContent();
    }
}
