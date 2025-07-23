<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use ResponseTrait;

    public function unread(Request $request)
    {
        $userId = $request->user()->id;

    $notifications = Notification::where('user_id', $userId)
        ->where('read', false)
        ->latest()
        ->get();

    Notification::where('user_id', $userId)
        ->where('read', false)
        ->update(['read' => true]);

        return $this->success($notifications, 'Unread notifications');
    }
}
