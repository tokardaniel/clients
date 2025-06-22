<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

use \App\Services\ClientServices;
use App\Models\Client;

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

    public function getClientByName(String $name): array | Client {
        return $this->clientServices->getClientByName($name);
    }

    public function getClientByPersonalId(String $id): array | Client {
        return $this->clientServices->getClientByPersonalId($id);
    }

}
