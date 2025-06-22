<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

use \App\Services\ClientService;
use App\Models\Client;

class ClientController extends Controller {
    public function __construct(private ClientService $clientService) {
        $this->clientService = $clientService;
    }

    public function index(): View {
        $clients = $this->clientService->getAllClients();

        return view('clients', data: [
            'clients' => $clients,
        ]);
    }

    public function getClientById(int $id): ?Array {
        return $this->clientService->getClientDataById($id);
    }

    public function getClientByName(String $name): array | Client {
        return $this->clientService->getClientByName($name);
    }

    public function getClientByPersonalId(String $id): array | Client {
        return $this->clientService->getClientByPersonalId($id);
    }

}
