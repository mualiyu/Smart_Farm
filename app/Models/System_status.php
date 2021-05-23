<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System_status extends Model
{
    use HasFactory;

    protected $fillable = [
        'pump',
        'mode',
    ];
}
