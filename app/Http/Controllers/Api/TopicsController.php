<?php

namespace App\Http\Controllers\Api;

use App\Models\Topic;
use App\Transformers\TopicTransformer;
use App\Http\Requests\Api\TopicRequest;
use Illuminate\Support\Facades\Auth;

class TopicsController extends Controller
{
    /**
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $topics = Topic::all();
        return $this->response->collection($topics, new TopicTransformer('collection'));
    }

    /**
     * @param Topic $topic
     * @return \Dingo\Api\Http\Response
     */
    public function show(Topic $topic)
    {
        return $this->response->item($topic, new TopicTransformer('item'));
    }

    /**
     * @param TopicRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(TopicRequest $request)
    {
        $attributes = $request->all();
        $attributes['user_id'] = Auth::id();

        $topic = Topic::create($attributes);
        return $this->response->created(app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('api.topics.show', $topic->id));
    }

    /**
     * @param Topic $topic
     * @param TopicRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function update(Topic $topic, TopicRequest $request)
    {
        $topic->update($request->all());
        return $this->response->noContent();
    }

    /**
     * @param Topic $topic
     * @return \Dingo\Api\Http\Response
     * @throws \Exception
     */
    public function destroy(Topic $topic)
    {
        $topic->delete();
        return $this->response->noContent();
    }
}
