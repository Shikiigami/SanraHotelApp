<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    use HasFactory;
    protected $tabel = 'checkins';
    protected $primaryKey = 'id';

    protected $fillable = [
    'reservation_id', 
    'guest_id', 
    'room_id', 
    'actual_check_in_time', 
    'actual_check_out_time', 
    'deposit', 
    'total_amount', 
    'balance', 
    'remarks',
    'status', 
    'payment_status', 
    'payment_method', 
    'payment_reference', 
    'created_by', 
    'updated_by'
];


    // A reservation belongs to one guest
    public function guest()
    {
        return $this->belongsTo(Guest::class, 'guest_id', 'id');
    }

    // A reservation belongs to one room
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }


    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id', 'id');
    }

     public function billing()
    {
        return $this->hasMany(Billing::class);
    }
}
