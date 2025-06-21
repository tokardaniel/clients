<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Car;

class Client extends Model
{
    protected $table = 'clients';

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}
