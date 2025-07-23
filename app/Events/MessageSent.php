<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;
class MessageSent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $message;
    /**
     * Create a new event instance.
     */
    public function __construct(Message $message)
    {
        $this->message = $message->load('sender:id,name,role');
    }


    /**
     * Get the channels the event should broadcast on.
    *
    * @return array<int, \Illuminate\Broadcasting\Channel>
    */
    public function broadcastOn()
    {
        // قناة خاصة باسم المستخدم المستلم
        return new Channel('user.' . $this->message->receiver_id);
    }

     public function broadcastWith()
    {
        return [
            'id'           => $this->message->id,
            'message_text' => $this->message->message_text,
            'sender'       => [
                'id'   => $this->message->sender->id,
                'name' => $this->message->sender->name,
                'role' => $this->message->sender->role,
            ],
            'sent_at' => $this->message->created_at->toDateTimeString(),
        ];
    }

    public function broadcastAs()
    {
        return 'new-message';
    }

}
