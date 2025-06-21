<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Client;
use App\Models\Service;

class ClientServices {

    private Client $client;

    function __construct(Client $client) {
        $this->client = $client;
    }

    public function getAllClients(): ?LengthAwarePaginator {
        return $this->client->paginate();
    }

    function getClientDataById(int $id): ?Array {
        $client = $this->getClientById($id);

        $cars = [];
        foreach ($client?->cars()->get() as $car) {
            $cars[] = [
                'id' => $car->id,
                'type' => $car->type,
                'registered' => $car->registered,
                'ownbrand' => $car->ownbrand ? 'igen': 'nem',
                'accidents' => $car->accidents,
            ];
        }

        return [
            'client' => $client,
            'cars' => $cars,
            'services' => $client?->services()->get(),
            'maxLognumberOfName' => $this->getMaxLognumberOfName($client->id)?->event,
            'maxLognumberOfDate' => $this->getMaxLognumberOfName($client->id)?->event_time,
        ];
    }

    private function getMaxLognumberOfName(int $id) {
        $max = Service::where('client_id', $id)->max('log_number');
        return Service::orderBy('event_time', 'desc')
                ->where('client_id', $id)
                ->where('log_number', $max)
                ->first();
    }

    private function getClientById(int $id): ?Client {
        return $this->client->find($id);
    }
}


