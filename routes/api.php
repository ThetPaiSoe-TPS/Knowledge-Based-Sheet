<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PostAuthoController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
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

// Auth routes (public)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ============================================
// PASSWORD RESET ROUTES (Public)
// ============================================

// 1. Request password reset link
Route::post('/password/forgot', [PasswordResetController::class, 'sendResetLink']);

// 2. Verify token
Route::post('/password/verify-token', [PasswordResetController::class, 'verifyToken']);

// 3. Reset password
Route::post('/password/reset', [PasswordResetController::class, 'reset']);

// 4. Check reset status
Route::post('/password/check-status', [PasswordResetController::class, 'checkStatus']);

// ============================================
// PROTECTED ROUTES (Require Authentication)
// ============================================
Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('/renew-token', [AuthController::class, 'renew']);

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Post routes with authorization
    Route::get('/posts', [PostAuthoController::class, 'index']);
    Route::get('/posts/{id}', [PostAuthoController::class, 'show']);
    Route::post('/posts', [PostAuthoController::class, 'store']);
    Route::put('/posts/{id}', [PostAuthoController::class, 'update']);
    Route::delete('/posts/{id}', [PostAuthoController::class, 'destroy']);
    Route::post('/posts/{id}/publish', [PostAuthoController::class, 'publish']);


    // ✅ ADD THIS: Create order route
    Route::post('/orders', [OrderController::class, 'createOrder']);

    // Order management
    Route::post('/orders/{orderId}/ship', [OrderController::class, 'shipOrder']);

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

    Route::prefix('employees')->group(function () {
        Route::get('/', [EmployeeController::class, 'index']);
        Route::post('/', [EmployeeController::class, 'store']);
        Route::get('/{id}', [EmployeeController::class, 'show']);
        Route::put('/{id}', [EmployeeController::class, 'update']);
        Route::delete('/{id}', [EmployeeController::class, 'destroy']);
    });

    // Newsletter routes
    Route::post('/newsletters/send', [NewsletterController::class, 'send']);
    Route::get('/newsletters', [NewsletterController::class, 'index']);
    Route::get('/newsletters/{id}/status', [NewsletterController::class, 'status']);

    // Subscriber routes
    Route::post('/subscribers', [NewsletterController::class, 'subscribe']);
    Route::get('/subscribers', [NewsletterController::class, 'subscribers']);
    Route::put('/subscribers/{id}/unsubscribe', [NewsletterController::class, 'unsubscribe']);

    Route::post('/images/upload', [ImageController::class, 'upload']);
    Route::get('/images/{id}/status', [ImageController::class, 'status']);

    Route::post('/welcome', [WelcomeController::class, 'store']);
    Route::get('/welcome/{id}/status', [WelcomeController::class, 'status']);

    Route::post('/reports/generate', [ReportController::class, 'generate']);
    Route::get('/reports/{id}/status', [ReportController::class, 'status']);
    Route::get('/reports/{id}/download', [ReportController::class, 'download']);
});
