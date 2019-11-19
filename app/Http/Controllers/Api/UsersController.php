<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserRequest;
use Illuminate\Support\Facades\Auth;
use App\Transformers\UserTransformer;

class UsersController extends Controller
{
    /**
     * @return \Dingo\Api\Http\Response
     */
    public function show()
    {
        $user = Auth::guard('api')->user();
        return $this->response->item($user, new UserTransformer());
    }

    /**
     * @param UserRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function update(UserRequest $request)
    {
        $user = Auth::guard('api')->user();
        $user->update($request->all());

        return $this->response->noContent();
    }

    /**
     * @return \Dingo\Api\Http\Response
     */
    public function destroy()
    {
        $user = Auth::guard('api')->user();
        $user->delete();

        return $this->response->noContent();
    }
}
