<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\DashboardController;

// Broadcast::routes();

// Broadcast::channel('chat.{receiverId}', function ($user, $receiverId) {
//     return (int) $user->id === (int) $receiverId;
// });

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('/portfolio', [PortfolioController::class, 'index']);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/send-message', [DashboardController::class, 'send_message'])->middleware(['auth', 'verified'])->name('send-message');

Route::get('/load-chat', [DashboardController::class, 'load_chat'])->middleware(['auth', 'verified'])->name('load-chat');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
