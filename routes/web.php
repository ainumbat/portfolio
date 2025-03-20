<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// Route::get('/portfolio', function () {
//     return Inertia::render('Portfolio');
// })->name('portfolio');

Route::get('/portfolio', [PortfolioController::class, 'index']);

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
}) ->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
