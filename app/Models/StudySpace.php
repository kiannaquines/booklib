<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudySpace extends Model
{
    protected $table = 'study_space';

    protected $fillable = [
        'name',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
