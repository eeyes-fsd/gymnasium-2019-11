<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\HealthRequest;
use App\Models\Health;
use App\Transformers\HealthTransformer;
use Illuminate\Support\Facades\Auth;

class HealthController extends Controller
{
    /**
     * @return \Dingo\Api\Http\Response
     */
    public function show()
    {
        $health = Auth::guard('api')->user()->health;
        $this->authorize('show', $health);
        return $this->response->item($health, new HealthTransformer());
    }

    /**
     * @param HealthRequest $request
     * @return \Dingo\Api\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(HealthRequest $request)
    {
        // 如果已存在身体情况，调用更新数据
        if (Auth::guard('api')->user()->health)
        {
            return $this->update($request);
        }

        $attributes = $request->all();
        $attributes['user_id'] = Auth::guard('api')->id;

        Health::create($attributes);

        return $this->response->created(app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('api.health.show'));
    }

    /**
     * @param HealthRequest $request
     * @return \Dingo\Api\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(HealthRequest $request)
    {
        $health = Auth::guard('api')->user()->health;
        $this->authorize('update', $health);
        $health->update($request->all());

        return $this->response->noContent();
    }
}
