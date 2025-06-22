<?php

namespace App\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\MultipleRecordsFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Client;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class ClientServices {

    private Client $client;

    function __construct(Client $client) {
        $this->client = $client;
    }

    public function getAllClients(): ?LengthAwarePaginator {
        return $this->client->paginate();
    }

    public function getClientByPersonalId(String $id) {
        if (!$this->isValidateId($id)) return [ 'Error' => 'Id formátum nem megfelelő!' ];

        try {
            return $this->client::withCount(['cars', 'services'])->where('card_number', '=', $id)->firstOrFail();
        } catch (ModelNotFoundException) {
            return ['Error' => 'Okmányazonosító nem létezik!'];
        }
    }

    public function getClientByName(String $name): Client | array {
        if (!strlen(trim($name))) {
            return [
                'Error' => 'Név mező üresen lett beküldve!'
            ];
        }
        try {
            return $this->client::withCount(['cars', 'services'])->where('name', 'like', "%{$name}%")->sole();
        }
        catch (ModelNotFoundException) {
            return ['Error' => 'Nincs találat!'];
        }
        catch (MultipleRecordsFoundException) {
            return ['Error' => 'Több találat is van, pontosítsd a keresést!'];
        }
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

    private function isValidateId($id) : bool {
        if (!strlen(trim($id))) {
            return false;
        }
        $pattern = "/^[0-9,a-z,A-Z]*$/";
        return preg_match($pattern, $id);
    }

    private function getMaxLognumberOfName(int $id) {
        $max = Service::where('client_id', $id)->max('log_number');
        return Service::orderBy('event_time', 'desc')
                ->where('client_id', $id)
                ->where('log_number', $max)
                ->first();
    }

    private function getClientById(int $id): ?Client {
        return $this->client->where('id', '=', $id)->first();
    }
}


