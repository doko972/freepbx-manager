<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
   
    Route::get('/pdf/global-report', [PdfController::class, 'generateGlobalReport'])->name('pdf.global-report');
    Route::get('/pdf/client-report/{clientId}', [PdfController::class, 'generateClientReport'])->name('pdf.client-report');
    Route::get('/pdf/equipment-list/{clientId}', [PdfController::class, 'generateEquipmentList'])->name('pdf.equipment-list');
});

// Routes d'administration protégées par le middleware admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard admin
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Gestion des utilisateurs
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}/data', [AdminController::class, 'getUserData'])->name('users.data');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::patch('/users/{user}/role', [AdminController::class, 'updateRole'])->name('users.role');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    
    // Actions en lot pour les utilisateurs
    Route::post('/users/bulk-role', [AdminController::class, 'bulkUpdateRole'])->name('users.bulk-role');
    Route::post('/users/bulk-delete', [AdminController::class, 'bulkDeleteUsers'])->name('users.bulk-delete');
    
    // Export des utilisateurs
    Route::get('/users/export', [AdminController::class, 'exportUsers'])->name('users.export');
});

// Routes légales
Route::get('/terms', function () {
    return view('auth.terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('auth.privacy');
})->name('privacy');

require __DIR__ . '/auth.php';