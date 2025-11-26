<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $userId;

    public function __construct($order, $userId)
    {
        $this->order = $order;
        $this->userId = $userId;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->userId),
        ];
    }

    public function broadcastAs(): string
    {
        return 'order.notification';
    }

    public function broadcastWith(): array
    {
        return [
            'order' => $this->order->id,
            'title' => 'New Order Created',
            'message' => 'Order ID: ' . $this->order->id,
        ];
    }
}
