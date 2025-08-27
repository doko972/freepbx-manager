<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\PhoneNumberController;
use App\Http\Controllers\Api\EquipmentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Routes protégées par authentification
Route::middleware(['auth'])->prefix('v1')->group(function () {
   
    // Routes pour les clients
    Route::apiResource('clients', ClientController::class);
   
    // Routes pour les sociétés
    Route::apiResource('companies', CompanyController::class)
         ->except(['index', 'show']);
   
    // Routes pour les numéros de téléphone
    Route::apiResource('phone-numbers', PhoneNumberController::class)
         ->except(['index', 'show']);
   
    // Routes pour les équipements
    Route::apiResource('equipment', EquipmentController::class)
         ->except(['index', 'show']);
         
    // Route spéciale pour obtenir les types d'équipements
    Route::get('equipment/types', [EquipmentController::class, 'getTypes']);
});