<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Notifications\OrderShippedNotification;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // ✅ Add this method to create orders
    public function createOrder(Request $request)
    {
        $request->validate([
            'total' => 'required|numeric|min:0',
            'address' => 'required|string'
        ]);

        $order = Order::create([
            'user_id' => $request->user()->id,
            'total' => $request->total,
            'address' => $request->address,
            'status' => 'pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully',
            'data' => $order
        ], 201);
    }

    public function shipOrder(Request $request, $orderId)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        $order = Order::where('user_id', $user->id)->findOrFail($orderId);

        // Update order status
        $order->update(['status' => 'shipped']);

        // Send notification to user
        $orderData = [
            'id' => $order->id,
            'total' => $order->total,
            'address' => $order->address
        ];

        try {
            $user->notify(new OrderShippedNotification($orderData));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send notification: ' . $e->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order shipped and notification sent!',
            'data' => $order
        ]);
    }

    public function getUserNotifications(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'unread' => $user->unreadNotifications,
                'all' => $user->notifications,
                'count_unread' => $user->unreadNotifications->count(),
                'count_all' => $user->notifications->count()
            ]
        ]);
    }

    public function markNotificationAsRead(Request $request, $notificationId)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        try {
            $notification = $user->notifications()->findOrFail($notificationId);
            $notification->markAsRead();

            return response()->json([
                'success' => true,
                'message' => 'Notification marked as read',
                'data' => $notification
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found'
            ], 404);
        }
    }

    public function markAllNotificationsAsRead(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        $count = $user->unreadNotifications->count();
        $user->unreadNotifications->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read',
            'data' => [
                'marked_count' => $count
            ]
        ]);
    }

    public function deleteNotification(Request $request, $notificationId)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        try {
            $notification = $user->notifications()->findOrFail($notificationId);
            $notification->delete();

            return response()->json([
                'success' => true,
                'message' => 'Notification deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found'
            ], 404);
        }
    }
}
