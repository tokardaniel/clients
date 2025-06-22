<?php

namespace App\Services;

use App\Models\Car;

class CarServices {

    public function __construct(private Car $car) {
        $this->car = $car;
    }

    public function getCarDataById(int $id): ?Array {
        $car = $this->getCarById($id);

        $services = [];
        foreach ($car?->services()->get() as $service) {
            $services[] = [
                'log_number' => $service->log_number,
                'event' => $service->event,
                'event_time' => $service->event_time,
                'document_id' => $service->document_id,
            ];
        }

        return [
            'id' => $car->id,
            'client_id' => $car->client_id,
            'type' => $car->type,
            'registered' => $car->registered,
            'ownbrand' => $car->ownbrand ? 'igen' : 'nem',
            'accidents' => $car->accidents,
            'services' => $services
        ];
    }

    private function getCarById(int $id): ?Car {
        return $this->car->find($id)->first();
    }

}
