<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Actuator_node;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Actuator extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value',
        'actuator_node_id'
    ];

    public function actuator_node(): BelongsTo
    {
        return $this->belongsTo(Actuator_node::class);
    }
}
