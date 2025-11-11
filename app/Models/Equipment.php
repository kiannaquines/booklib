<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipments';

    protected $fillable = [
        'name',
        'image',
        'description',
        'status',
        'total_quantity',
        'available_quantity',
        'max_slots',
        'reserved_today',
        'last_reset_date',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'last_reset_date' => 'date',
    ];
}
