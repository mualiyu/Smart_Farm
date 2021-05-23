<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Actuator;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Actuator_node extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function actuators(): HasMany
    {
        return $this->hasMany(Actuator::class);
    }
}
