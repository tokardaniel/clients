<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

Use App\Models\Client;

class Service extends Model
{
    protected $table = 'services';

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }
}
