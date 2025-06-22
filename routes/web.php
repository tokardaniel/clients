<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CarController;

Route::get('/', [ClientController::class, 'index']);
Route::get('/client/{id}', [ClientController::class, 'getClientById']);
Route::get('/client/search-by-name/{name}', [ClientController::class, 'getClientByName']);
Route::get('/client/search-by-personal-id/{id}', [ClientController::class, 'getClientByPersonalId']);
Route::get('/car/{id}', [CarController::class, 'getCarById']);
