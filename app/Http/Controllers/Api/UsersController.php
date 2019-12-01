<?php

namespace App\Http\Controllers\Api;

use App\Handlers\CaptchaHandler;
use App\Http\Requests\Api\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    /**
     * @return \Dingo\Api\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show()
    {
        $user = Auth::guard('api')->user();
        $this->authorize('show', $user);
        return $this->response->item($user, new UserTransformer());
    }

    /**
     * @param UserRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(UserRequest $request, CaptchaHandler $handler)
    {
        $attributes = $request->except(['captcha']);

        if (!$handler->verify(0, $request->phone, $request->captcha))
        {
            return $this->response->array([
                'phone' => [
                    '手机号码未验证'
                ]
            ])->setStatusCode(422);
        }

        $attributes['password'] = '*';

        $user = User::create($attributes);

        if ($request->has('share_id')) {
            DB::table('shares')->insert([
                'share_id' => $request->share_id,
                'user_id' => $user->id,
            ]);
        }

        return $this->response->created();
    }

    /**
     * @param UserRequest $request
     * @param CaptchaHandler $handler
     * @return \Dingo\Api\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UserRequest $request, CaptchaHandler $handler)
    {
        $user = Auth::guard('api')->user();
        $this->authorize('update', $user);
        $attributes = $request->all();

        if (!$handler->verify($user->id, $request->phone, $request->captcha)) goto error422;

        unset($attributes['captcha']);
        $user->update($attributes);

        return $this->response->noContent();

        error422:
        return $this->response->array([
            'phone' => [
                '手机号码未验证'
            ]
        ])->setStatusCode(422);
    }

    /**
     * @return \Dingo\Api\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy()
    {
        $user = Auth::guard('api')->user();
        $this->authorize('delete', $user);
        $user->delete();

        return $this->response->noContent();
    }
}
