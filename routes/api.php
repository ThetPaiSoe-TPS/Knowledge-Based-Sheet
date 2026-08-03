<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/users', [UserController::class, 'index']);
Route::delete('/users/bulk-delete', [UserController::class, 'bulkDelete']);
Route::put('/users/bulk-update-status', [UserController::class, 'bulkUpdateStatus']);
Route::put('/users/bulk-activate', [UserController::class, 'bulkActivate']);
Route::put('/users/bulk-deactivate', [UserController::class, 'bulkDeactivate']);
Route::put('/users/bulk-suspend', [UserController::class, 'bulkSuspend']);

Route::get('files', [FileUploadController::class, 'index']);
Route::post('files/upload', [FileUploadController::class, 'upload']);
Route::get('files/preview/{id}', [FileUploadController::class, 'preview']);
Route::delete('files/preview/{id}', [FileUploadController::class, 'delete']);


Route::apiResource('items', ItemController::class);

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'show']);
Route::post('/posts', [PostController::class, 'store']);
Route::put('/posts/{id}', [PostController::class, 'update']);
Route::delete('/posts/{id}', [PostController::class, 'destroy']);
Route::get('/users/{userId}/posts', [PostController::class, 'getPostsByUser']);

// Comments routes
Route::get('/posts/{postId}/comments', [CommentController::class, 'index']);
Route::post('/comments', [CommentController::class, 'store']);
Route::put('/comments/{id}/approve', [CommentController::class, 'approve']);
Route::delete('/comments/{id}', [CommentController::class, 'destroy']);

Route::prefix('notifications')->group(function () {
    // Get all notifications for a user
    Route::get('/user/{userId}', [NotificationController::class, 'index']);

    // Get unread notifications
    Route::get('/user/{userId}/unread', [NotificationController::class, 'unread']);

    // Mark all as read
    Route::put('/user/{userId}/mark-all-read', [NotificationController::class, 'markAllAsRead']);

    // Mark single as read
    Route::put('/{notificationId}/mark-read', [NotificationController::class, 'markAsRead']);

    // Delete notification
    Route::delete('/{notificationId}', [NotificationController::class, 'destroy']);


    Route::post('/orders/{orderId}/ship', [OrderController::class, 'shipOrder']);

    // Notification routes
    Route::get('/notifications', [OrderController::class, 'getUserNotifications']);
    Route::put('/notifications/{notificationId}/read', [OrderController::class, 'markNotificationAsRead']);
    Route::put('/notifications/read-all', [OrderController::class, 'markAllNotificationsAsRead']);
    Route::delete('/notifications/{notificationId}', [OrderController::class, 'deleteNotification']);
});
