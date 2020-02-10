<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'share_id' => 'required'
        ]);

        /** @var User $user */
        if (!$user = User::where('share_id', $request->share_id)->first()) abort(404, '未找到该用户');

        return view('register', compact('user'));
    }
}
