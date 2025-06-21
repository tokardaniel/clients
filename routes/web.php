<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

Route::get('/', [ClientController::class, 'index']);
Route::get('/client/{id}', [ClientController::class, 'getClientById']);
