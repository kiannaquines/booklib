<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Books extends Model
{
    use HasFactory;
    protected $table = 'books';

    protected $fillable = [
        'title',
        'author',
        'image',
        'description',
        'status',
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
