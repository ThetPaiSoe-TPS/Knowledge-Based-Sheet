<?php

use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\ItemController;
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
