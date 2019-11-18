<?php

namespace App\Http\Controllers\Api;

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


    public function update()
    {
        // TODO
    }

    public function destroy()
    {
        // TODO
    }
}
