<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class OrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;
    protected $title;
    protected $message;
    protected $type;

    /**
     * Create a new notification instance.
     */
    public function __construct($order, $title = null, $message = null, $type = 'order')
    {
        $this->order = $order;
        $this->title = $title ?? $order->order_code;
        $this->message = $message ?? 'Your order has been placed successfully!';
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification for database.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_code' => $this->order->order_code ?? $this->order->id,
            'title' => $this->title,
            'message' => $this->message,
            'type' => $this->type,
            'url' => '/my-account/order/' . $this->order->id,
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'id' => $this->id,
            'order_id' => $this->order->id,
            'order_code' => $this->order->order_code ?? $this->order->id,
            'title' => $this->title,
            'message' => $this->message,
            'type' => $this->type,
            'url' => '/my-account/order/' . $this->order->id,
            'time' => 'Just now',
        ]);
    }

    /**
     * Get the type of the notification being broadcast.
     */
    public function broadcastType(): string
    {
        return 'order.notification';
    }
}
