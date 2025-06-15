<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookReservation extends Model
{
    protected $table = 'book_reservation';

    protected $fillable = [
        'book_id',
        'user_id',
        'status',
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function book()
    {
        return $this->belongsTo(Books::class);
    }
}
