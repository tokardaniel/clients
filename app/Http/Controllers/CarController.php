<?php

namespace App\Http\Controllers;

use App\Services\CarServices;

class CarController extends Controller
{
    function __construct(private CarServices $carServices) {
        $this->carServices = $carServices;
    }

    public function getCarById(int $id): ?Array {
        return $this->carServices->getCarDataById($id);
    }
}
