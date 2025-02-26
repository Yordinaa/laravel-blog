<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


// Route::get('/posts', action: [PostController::class, 'index']);

Route::post('register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);



Route::get('/user', function (Request $request) {
    return auth()->user() ?? 'Guest';
});


Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('posts', PostController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
});