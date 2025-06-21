<?php

use Illuminate\Support\Facades\Route;
use App\Services\ClientServices;

Route::get('/', function (ClientServices $clientServices): \Illuminate\View\View {
    return view('clients', data: [
        'clients' => $clientServices->getAllClients(),
    ]);
});
