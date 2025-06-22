<?php

namespace App\Http\Controllers;

use App\Services\CarService;

class CarController extends Controller
{
    function __construct(private CarService $carService) {
        $this->carService = $carService;
    }

    public function getCarById(int $id): ?Array {
        return $this->carService->getCarDataById($id);
    }
}
