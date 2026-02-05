<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArtworkController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\Admin\LearningController as AdminLearningController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/artworks', [ArtworkController::class, 'index'])->name('artworks.index');
Route::get('/artworks/{id}', [ArtworkController::class, 'show'])->name('artworks.show');

Route::get('/research', [ResearchController::class, 'index'])->name('research.index');
Route::get('/research/{slug}', [ResearchController::class, 'show'])->name('research.show');
Route::get('/virtual-exhibition', [HomeController::class, 'virtualExhibition'])->name('virtual.exhibition');

Route::get('/learning', [LearningController::class, 'index'])->name('learning.index');
Route::get('/learning/{slug}', [LearningController::class, 'show'])->name('learning.show');

Route::post('/chatbot/chat', [App\Http\Controllers\ChatbotController::class, 'chat'])->name('chatbot.chat');
Route::get('/api/chatbot/status', [App\Http\Controllers\ChatbotController::class, 'status'])->name('chatbot.status');

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // User Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/artworks/create', [DashboardController::class, 'createArtwork'])->name('artworks.create');
    Route::post('/dashboard/artworks', [DashboardController::class, 'storeArtwork'])->name('artworks.store');
    Route::get('/dashboard/artworks/{artwork}/edit', [DashboardController::class, 'editArtwork'])->name('artworks.edit');
    Route::put('/dashboard/artworks/{artwork}', [DashboardController::class, 'updateArtwork'])->name('artworks.update');
    Route::post('/artworks/{artwork}/comments', [ArtworkController::class, 'storeComment'])->name('artworks.comments.store');
    
    // Research Management
    Route::get('/dashboard/research/create', [ResearchController::class, 'create'])->name('research.create');
    Route::post('/dashboard/research', [ResearchController::class, 'store'])->name('research.store');

    // Admin Routes (Simple check for now, can be middleware later)
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/artworks', [AdminController::class, 'manageArtworks'])->name('artworks');
        Route::get('/users', [AdminController::class, 'manageUsers'])->name('users');
        Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
        Route::get('/gallery', [AdminController::class, 'gallery'])->name('gallery');
        Route::patch('/artworks/{artwork}/approve', [AdminController::class, 'approveArtwork'])->name('artworks.approve');
        Route::delete('/artworks/{artwork}', [AdminController::class, 'destroyArtwork'])->name('artworks.destroy');
        Route::resource('categories', AdminCategoryController::class);
        Route::resource('learning', AdminLearningController::class);
        
        // Settings
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::patch('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
