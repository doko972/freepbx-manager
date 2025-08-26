<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

// Routes pour la génération de PDF
Route::prefix('pdf')->name('pdf.')->group(function () {
    Route::get('client-report/{client}', [PdfController::class, 'generateClientReport'])
         ->name('client-report');
    Route::get('equipment-list/{client}', [PdfController::class, 'generateEquipmentList'])
         ->name('equipment-list');
    Route::get('global-report', [PdfController::class, 'generateGlobalReport'])
         ->name('global-report');
});

Route::fallback(function () {
    return view('dashboard');
});