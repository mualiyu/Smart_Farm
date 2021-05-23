<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sensor;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sensor_node extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function sensors(): HasMany
    {
        return $this->hasMany(Sensor::class);
    }
}
