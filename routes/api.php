yes<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CentreController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\InscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function(){
    Route::post('/centres', [CentreController::class, 'store']);
    Route::patch('/centres/{centre}/valider', [CentreController::class, 'validate']);

    Route::post('/formations', [FormationController::class, 'store']);
    Route::get('/formations', [FormationController::class, 'index']);
    
    Route::post('/inscriptions', [InscriptionController::class, 'store']);
    Route::get('/inscriptions/{formation}', [InscriptionController::class, 'index']);

    // Route::get('/centres', [CentreController::class, 'show']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);