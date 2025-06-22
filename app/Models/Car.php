<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Service;

class Car extends Model
{
    protected $table = 'cars';

    public function services(): HasMany
    {
        return $this->hasMany(Service::class)->orderBy('event_time', 'desc');
    }
}
