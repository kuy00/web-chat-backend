<?php

namespace App\Events;

use App\Models\User;
use App\Models\DirectMessage;
use App\Models\DirectMessageContent;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BroadCastEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $user;
    private $directMessage;
    private $directMessageContent;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, DirectMessage $directMessage, DirectMessageContent $directMessageContent)
    {
        $this->user = $user;
        $this->directMessage = $directMessage;
        $this->directMessageContent = $directMessageContent;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('user.'.$this->user->id);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'direct_message' => $this->directMessage,
            'direct_message_content' => $this->directMessageContent,
        ];
    }
}
