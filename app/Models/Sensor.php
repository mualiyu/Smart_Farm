<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sensor_node;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sensor extends Model
{
    use HasFactory;

    protected $fillable = [
        'temperature',
        'humidity',
        'moisture',
        'sensor_node_id'
    ];

    public function sensor_node(): BelongsTo
    {
        return $this->belongsTo(Sensor_node::class);
    }
}
