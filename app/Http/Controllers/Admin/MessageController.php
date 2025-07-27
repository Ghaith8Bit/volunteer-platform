<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Notification;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    use ResponseTrait;

    public function inbox(Request $request)
    {
        $userId = $request->user()->id;

        $messages = Message::with(['sender:id,name,role'])
            ->where('receiver_id', $userId)
            ->latest()
            ->get();

        Message::where('receiver_id', $userId)
            ->where('read', false)
            ->update(['read' => true]);

        $formatted = $messages->map(function ($msg) {
            return [
                'id'           => $msg->id,
                'message_text' => $msg->message_text,
                'read'         => true,
                'sent_at'      => $msg->created_at->toDateTimeString(),
                'sender'       => [
                    'id'   => $msg->sender->id,
                    'name' => $msg->sender->name,
                    'role' => $msg->sender->role,
                ],
            ];
        });

        return $this->success($formatted, 'Inbox messages (marked as read)');
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id'  => 'required|exists:users,id',
            'message_text' => 'required|string|max:1000',
        ]);

        if ($request->receiver_id == $request->user()->id) {
            return $this->error('Cannot message yourself', 422);
        }

        $sender = $request->user();

        $message = Message::create([
            'sender_id'    => $sender->id,
            'receiver_id'  => $request->receiver_id,
            'message_text' => $request->message_text,
            'read'         => false,
        ]);

        Notification::create([
            'user_id' => $request->receiver_id,
            'message' => 'وصلك رسالة جديدة من الإدارة: ' . $sender->name,
            'read'    => false,
        ]);

        event(new \App\Events\MessageSent($message));

        return $this->success($message, 'Message sent and notification delivered', 201);
    }
}
