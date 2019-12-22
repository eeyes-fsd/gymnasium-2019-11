<?php

namespace App\Http\Controllers\Api;

use App\Handlers\AlgorithmHandler;
use App\Http\Requests\Api\HealthRequest;
use App\Models\Health;
use App\Transformers\HealthTransformer;
use Illuminate\Support\Facades\Auth;

class HealthController extends Controller
{
    /**
     * @return \Dingo\Api\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show()
    {
        $health = Auth::guard('api')->user()->health;
        if (!empty($health)) $this->authorize('show', $health);
        return $this->response->item($health, new HealthTransformer());
    }

    /**
     * @param HealthRequest $request
     * @return \Dingo\Api\Http\Response|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(HealthRequest $request, AlgorithmHandler $algorithm)
    {
        // 如果已存在身体情况，调用更新数据
        if (Auth::guard('api')->user()->health)
        {
            return $this->update($request, $algorithm);
        }

        $attributes = $request->all();
        $attributes['user_id'] = Auth::guard('api')->id();

        $health = Health::create($attributes);
        if (!$intake = $algorithm->calculate_intake($health)) {
            return $this->response->array([
                'code' => 422,
                'msg' => '选择了无效的锻炼目的'
            ])->setStatusCode(422);
        }

        return $this->response->created(app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('api.health.show'))->setContent($intake);
    }

    /**
     * @param HealthRequest $request
     * @param AlgorithmHandler $algorithm
     * @return \Dingo\Api\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(HealthRequest $request, AlgorithmHandler $algorithm)
    {
        $health = Auth::guard('api')->user()->health;
        $this->authorize('update', $health);
        $health->update($request->all());

        if (!$intake = $algorithm->calculate_intake($health)) {
            return $this->response->array([
                'code' => 422,
                'msg' => '选择了无效的锻炼目的'
            ])->setStatusCode(422);
        }

        return $this->response->array($intake);
    }
}
