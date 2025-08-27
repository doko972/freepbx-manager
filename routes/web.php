<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PdfController;
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

// Routes légales
Route::get('/terms', function () {
    return view('auth.terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('auth.privacy');
})->name('privacy');

require __DIR__ . '/auth.php';