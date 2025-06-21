<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

use \App\Services\ClientServices;
use App\Models\Service;

class ClientController extends Controller {
    public function __construct(private ClientServices $clientServices) {
        $this->clientServices = $clientServices;
    }

    public function index(): View {
        $clients = $this->clientServices->getAllClients();

        return view('clients', data: [
            'clients' => $clients,
        ]);
    }

    public function getClientById(int $id): ?Array {
        return $this->clientServices->getClientDataById($id);
    }


}
