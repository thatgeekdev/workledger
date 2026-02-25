<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\RoleController;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class,'register']);
    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout'])->middleware('auth:sanctum');

    Route::post('forgot-password', [AuthController::class,'forgotPassword']);
    Route::post('reset-password', [AuthController::class,'resetPassword']);

    Route::get('me', [ProfileController::class,'me'])->middleware('auth:sanctum');
    Route::put('profile', [ProfileController::class,'update'])->middleware('auth:sanctum');
});

Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    Route::get('users', [UserController::class,'index'])->middleware('can:viewAny,App\Models\User');
    Route::get('users/{id}', [UserController::class,'show'])->middleware('can:viewAny,App\Models\User');
    Route::put('users/{id}', [UserController::class,'update'])->middleware('can:viewAny,App\Models\User');
    Route::put('users/{id}/profile', [UserController::class,'update'])->middleware('can:viewAny,App\Models\User');

    // roles listing for admin UI
    Route::get('roles', [RoleController::class, 'index']);
    Route::post('users/{id}/assign-role', [RoleController::class, 'update']);
});
