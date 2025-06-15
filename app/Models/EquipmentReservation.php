<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentReservation extends Model
{
    protected $table = 'equipment_reservation';

    protected $fillable = [
        'equipment_id',
        'user_id',
        'study_space_id',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

}
