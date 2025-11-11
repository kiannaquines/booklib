<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeatReservation extends Model
{
    use HasFactory;
    protected $table = "seat_reservation";

    protected $fillable = ['reserved_seat', 'user_id', 'reason', 'start_time', 'end_time'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function space(){
        return $this->belongsTo(StudySpace::class, 'reserved_seat');
    }
}
