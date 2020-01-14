<?php

namespace App\Http\Controllers\Api;

use App\Handlers\AlgorithmHandler;
use App\Http\Requests\Api\HealthRequest;
use App\Models\Health;
use App\Transformers\HealthTransformer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class HealthController extends Controller
{
    /**
     * @param $detail
     * @return \Dingo\Api\Http\Response | void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($detail=null)
    {
        switch ($detail) {
            case 'intake':
                if (!$health = Auth::user()->health) {
                    return $this->response->noContent();
                }
                $intake = $health->intake;
                if (!$intake) {
                    return $this->response->errorNotFound('还未设置身体信息');
                }
                $intake['updated_at'] = $health->updated_at;
                return $this->responseParsingIntake($intake);
            default:
                $health = Auth::guard('api')->user()->health;
                if (!empty($health)) $this->authorize('show', $health); else return $this->response->errorNotFound('还未设置身体信息');
                return $this->response->item($health, new HealthTransformer());
        }
    }

    /**
     * @param HealthRequest $request
     * @param AlgorithmHandler $algorithm
     * @return \Dingo\Api\Http\Response
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

        if (count($intake['ratio']) > 1) {
            Cache::put('user:' . Auth::id() . ':intake:lt', 0);
        }

        $health->update(['intake' => $intake]);


        $intake['updated_at'] = $health->updated_at;
        return $this->responseParsingIntake($intake)->setStatusCode(201);
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

        if (count($intake['ratio']) > 1) {
            Cache::put('user:' . Auth::id() . ':intake_lt', 0);
        }

        $health->update(['intake' => $intake]);

        $intake['updated_at'] = $health->updated_at;
        return $this->responseParsingIntake($intake);
    }

    protected function responseParsingIntake(array $intake)
    {
        if (count($intake['ratio']) > 1) {
            $live_time = Cache::get('user:' . Auth::id() . ':intake_lt');
            foreach ($intake['ratio'] as $ratio) {
                if ($live_time -= $ratio['ttl'] < 0) {
                    if ($ratio['ttl'] === null) {
                        Cache::forget('user:' . Auth::id() . ':intake_lt');
                    }
                    break;
                }
            }
        } else {
            $ratio = $intake['ratio'][0];
        }

        return $this->response->array([
            'updated_at' => $intake['updated_at']->diffForHumans(),
            'energy' => $intake['energy'],
            'ratio' => $ratio[0] ?? null,
            'bmr_warn' => $intake['bmr_warn']
        ]);
    }
}
