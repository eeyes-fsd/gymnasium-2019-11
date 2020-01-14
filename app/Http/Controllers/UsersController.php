<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    //获取当前用户信息
    public function show(Request $request)
    {
        $user = $request->user();

        return $this->response->item($user, new UserTransformer());
    }

    //更新用户信息
    public function update(UserRequest $request)
    {
        $user = $request->user();

        $this->authorize('update', $user);

        $attributes = $request->all([
            'sex',
            'birthday',
            'height',
            'weight',
        ]);

        $user->update($attributes);

        return $this->response->noContent()->setStatusCode(200);
    }
    //删除用户(?)

    public function destroy(Request $request)
    {
        $user = $request->user();

        $this->authorize('update', $user);

        $user->delete();

        return $this->response->noContent()->setStatusCode(200);
    }
}
