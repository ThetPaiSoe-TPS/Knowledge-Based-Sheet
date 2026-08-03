<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Notifications\OrderShippedNotification;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function shipOrder(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        // Update order status
        $order->update(['status' => 'shipped']);

        // Send notification to user
        $orderData = [
            'id' => $order->id,
            'total' => $order->total,
            'address' => $order->address
        ];

        $order->user->notify(new OrderShippedNotification($orderData));

        return response()->json([
            'message' => 'Order shipped and notification sent!',
            'order' => $order
        ]);
    }

    public function getUserNotifications(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'unread' => $user->unreadNotifications,
            'all' => $user->notifications,
            'count_unread' => $user->unreadNotifications->count()
        ]);
    }

    public function markNotificationAsRead(Request $request, $notificationId)
    {
        $notification = $request->user()->notifications()->findOrFail($notificationId);
        $notification->markAsRead();

        return response()->json([
            'message' => 'Notification marked as read',
            'notification' => $notification
        ]);
    }

    public function markAllNotificationsAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return response()->json([
            'message' => 'All notifications marked as read'
        ]);
    }

    public function deleteNotification(Request $request, $notificationId)
    {
        $notification = $request->user()->notifications()->findOrFail($notificationId);
        $notification->delete();

        return response()->json([
            'message' => 'Notification deleted successfully'
        ]);
    }
}
