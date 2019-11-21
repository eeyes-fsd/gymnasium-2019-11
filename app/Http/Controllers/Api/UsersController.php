<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserRequest;
use Illuminate\Support\Facades\Auth;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\Cache;
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UserRequest $request)
    {
        $user = Auth::guard('api')->user();
        $this->authorize('update', $user);
        $attributes = $request->all();

        if (!$phone = Cache::get('verify_phone:' . $user->id)) goto error422;
        if ($phone != $attributes['phone'] . '.' . $attributes['captcha']) goto error422;

        unset($attributes['captcha']);
        $user->update($attributes);

        Cache::forget('verify_phone:' . $user->id);

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
