<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public routes (no authentication needed)
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

// Post routes (public for viewing)
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'show']);
Route::get('/users/{userId}/posts', [PostController::class, 'getPostsByUser']);

// Auth routes (public)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Comments routes (public for viewing)
Route::get('/posts/{postId}/comments', [CommentController::class, 'index']);

// ============================================
// PROTECTED ROUTES (Require Authentication)
// ============================================
Route::middleware('auth:sanctum')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // ✅ ADD THIS: Create order route
    Route::post('/orders', [OrderController::class, 'createOrder']);

    // Order management
    Route::post('/orders/{orderId}/ship', [OrderController::class, 'shipOrder']);

    // Post management
    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/posts/{id}', [PostController::class, 'update']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);

    // Comment management
    Route::post('/comments', [CommentController::class, 'store']);
    Route::put('/comments/{id}/approve', [CommentController::class, 'approve']);
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']);

    // ============================================
    // NOTIFICATION ROUTES (Using OrderController)
    // ============================================
    Route::get('/notifications', [OrderController::class, 'getUserNotifications']);
    Route::put('/notifications/{notificationId}/read', [OrderController::class, 'markNotificationAsRead']);
    Route::put('/notifications/read-all', [OrderController::class, 'markAllNotificationsAsRead']);
    Route::delete('/notifications/{notificationId}', [OrderController::class, 'deleteNotification']);

    // ============================================
    // NOTIFICATION ROUTES (Using NotificationController)
    // ============================================
    Route::prefix('notifications')->group(function () {
        Route::get('/user/{userId}', [NotificationController::class, 'index']);
        Route::get('/user/{userId}/unread', [NotificationController::class, 'unread']);
        Route::put('/user/{userId}/mark-all-read', [NotificationController::class, 'markAllAsRead']);
        Route::put('/{notificationId}/mark-read', [NotificationController::class, 'markAsRead']);
        Route::delete('/{notificationId}', [NotificationController::class, 'destroy']);
    });

    // Newsletter routes
    Route::post('/newsletters/send', [NewsletterController::class, 'send']);
    Route::get('/newsletters', [NewsletterController::class, 'index']);
    Route::get('/newsletters/{id}/status', [NewsletterController::class, 'status']);

    // Subscriber routes
    Route::post('/subscribers', [NewsletterController::class, 'subscribe']);
    Route::get('/subscribers', [NewsletterController::class, 'subscribers']);
    Route::put('/subscribers/{id}/unsubscribe', [NewsletterController::class, 'unsubscribe']);
});
