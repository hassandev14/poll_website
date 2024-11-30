<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\VoteController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\AdminMiddleware;

// Clear Cache Routes (for convenience)
Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    return "Cache cleared successfully!";
});

// Authentication Routes (no middleware)
Route::get('/', [LoginController::class, 'index'])->name('login')->withoutMiddleware([Authenticate::class]);
Route::get('/logout', [LoginController::class, 'logout'])->withoutMiddleware([Authenticate::class]);
Route::post('/login', [LoginController::class, 'login'])->withoutMiddleware([Authenticate::class]);
Route::get('/signup', [LoginController::class, 'signup_view'])->withoutMiddleware([Authenticate::class]);
Route::post('/signup', [LoginController::class, 'store'])->withoutMiddleware([Authenticate::class]);

// Authenticated Routes (with middleware)
Route::middleware([Authenticate::class])->group(function () {

    // Poll Admin Routes (Add/Edit/Delete)
    Route::middleware([AdminMiddleware::class])->group(function () {
        
        // Dashboard Routes
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/votes-list', [DashboardController::class, 'showVotes'])->name('votes.list');
        Route::get('/detailed-votes', [DashboardController::class, 'showVotes'])->name('votes.detailed');


        Route::get('/add_poll', [PollController::class, 'create'])->name('polls.create');
        Route::post('/add_poll', [PollController::class, 'store'])->name('polls.store');
        Route::get('/edit_poll/{id}', [PollController::class, 'edit'])->name('polls.edit');
        Route::post('/edit_poll/{id}', [PollController::class, 'update'])->name('polls.update');
        Route::get('/delete_poll/{id}', [PollController::class, 'destroy'])->name('polls.delete');

        // fetching active user
        Route::get('/active_user', [LoginController::class, 'active_user'])->name('/active_user');
    
    });
    // Poll Route
    Route::get('/polls', [PollController::class, 'index'])->name('/polls');  // List all polls

     // Poll Routes
     Route::get('/polls/{id}', [PollController::class, 'showPollsForVoting'])->name('polls.vote');  // Poll voting page
     Route::post('polls/{poll}/vote', [PollController::class, 'vote']);  // Handle vote submission
});
