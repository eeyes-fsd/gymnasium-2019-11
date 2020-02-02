<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Transformers\NotificationTransformer;

class NotificationsController extends Controller
{
    public function index(Request $request)
    {
        /** @var \Illuminate\Notifications\DatabaseNotificationCollection $notifications */
        $notifications = Auth::guard('api')->user()->notifications;

        $notifications = $notifications->forPage(
            $request->page,
            $request->per_page
        );

        $notifications->markAsRead();

        return $this->response->collection($notifications, new NotificationTransformer());
    }

    /**
     * @return mixed
     */
    public function stats()
    {
        $notifications = Auth::guard('api')->user()->notifications_count;
        return $this->response->array([
            'count' => $notifications,
        ]);
    }

    /**
     * @return \Dingo\Api\Http\Response
     */
    public function read()
    {
        Auth::guard('api')->user()->notifications->markAsRead();
        return $this->response->noContent();
    }
}
