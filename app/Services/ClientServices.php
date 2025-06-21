<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Client;

class ClientServices {

    private Client $client;

    function __construct(Client $client) {
        $this->client = $client;
    }

    public function getAllClients(): LengthAwarePaginator {
        return $this->client->paginate();
    }
}


