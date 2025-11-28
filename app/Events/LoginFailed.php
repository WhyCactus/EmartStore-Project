<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LoginFailed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $email;
    public $ipAddress;
    public $userAgent;
    public $reason;

    public function __construct($email, $ipAddress, $userAgent, $reason)
    {
        $this->email = $email;
        $this->ipAddress = $ipAddress;
        $this->userAgent = $userAgent;
        $this->reason = $reason;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
