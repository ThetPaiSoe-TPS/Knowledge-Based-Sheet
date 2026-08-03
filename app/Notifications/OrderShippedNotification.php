<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderShippedNotification extends Notification
{
    use Queueable;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'order_id' => $this->order['id'],
            'order_total' => $this->order['total'],
            'address' => $this->order['address'],
            'message' => 'Order #' . $this->order['id'] . ' has been shipped!',
            'type' => 'order_shipped'
        ];
    }

    public function toArray($notifiable): array
    {
        return [
            'order_id' => $this->order['id'],
            'order_total' => $this->order['total']
        ];
    }
}