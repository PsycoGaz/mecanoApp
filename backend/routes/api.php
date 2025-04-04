<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\PieceDetacheeController;
use App\Http\Controllers\ReparationController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\VoitureController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function () {
    return response()->json(['message' => 'This is a test route']);
});

// Client routes
Route::get('/clients', [ClientController::class, 'index']);
Route::post('/clients', [ClientController::class, 'store']);
Route::get('/clients/{id}', [ClientController::class, 'show']);
// Voiture Routes
Route::get('/voitures', [VoitureController::class, 'index']);  // Get all cars
Route::post('/voitures', [VoitureController::class, 'store']); // Add a new car
Route::get('/voitures/{id}', [VoitureController::class, 'show']); // Get a specific car
Route::put('/voitures/{id}', [VoitureController::class, 'update']); // Update a car
Route::delete('/voitures/{id}', [VoitureController::class, 'destroy']); // Delete a car
// Employe (Employee) routes
Route::get('/employes', [EmployeController::class, 'index']);  // Get all employees with repairs
Route::post('/employes', [EmployeController::class, 'store']); // Add a new employee
Route::get('/employes/{id}', [EmployeController::class, 'show']); // Get a specific employee with repairs
Route::put('/employes/{id}', [EmployeController::class, 'update']); // Update an employee
Route::delete('/employes/{id}', [EmployeController::class, 'destroy']); // Delete an employee
// Piece Detachee (Spare Part) routes
Route::get('/pieces', [PieceDetacheeController::class, 'index']);  // Get all spare parts
Route::post('/pieces', [PieceDetacheeController::class, 'store']); // Add a new spare part
Route::get('/pieces/{id}', [PieceDetacheeController::class, 'show']); // Get a specific spare part
Route::put('/pieces/{id}', [PieceDetacheeController::class, 'update']); // Update a specific spare part
Route::delete('/pieces/{id}', [PieceDetacheeController::class, 'destroy']); // Delete a spare part
// Reparation routes
Route::get('/reparations', [ReparationController::class, 'index']);  // Get all reparations
Route::post('/reparations', [ReparationController::class, 'store']); // Add a new reparation
Route::get('/reparations/{id}', [ReparationController::class, 'show']); // Get a specific reparation
Route::put('/reparations/{id}', [ReparationController::class, 'update']); // Update a specific reparation
Route::delete('/reparations/{id}', [ReparationController::class, 'destroy']); // Delete a reparation
// Statistique routes
Route::get('/statistiques', [StatistiqueController::class, 'index']); // Get all statistics
Route::post('/statistiques', [StatistiqueController::class, 'store']); // Create a new statistic
Route::get('/statistiques/{id}', [StatistiqueController::class, 'show']); // Get a specific statistic
Route::put('/statistiques/{id}', [StatistiqueController::class, 'update']); // Update a specific statistic
Route::delete('/statistiques/{id}', [StatistiqueController::class, 'destroy']); // Delete a statistic

// Generate real-time statistics
Route::get('/generate-stats', [StatistiqueController::class, 'generateStats']);
