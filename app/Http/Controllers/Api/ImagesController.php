<?php

namespace App\Http\Controllers\Api;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Handlers\ImageUploadHandler;

class ImagesController extends Controller
{
    /**
     * @param Request $request
     * @param ImageUploadHandler $handler
     * @return \Dingo\Api\Http\Response
     */
    public function save(Request $request, ImageUploadHandler $handler)
    {
        /** @var \App\Models\User $user */
        $user = Auth::guard('api')->user();

        $result = $handler->save($request->image, 'topics', $user->id);

        $image = new Image;
        $image->user()->associate($user);
        $image->path = $result['path'];

        $image->save();

        return $this->response->created($image->path);
    }
}
