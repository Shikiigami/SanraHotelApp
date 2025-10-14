<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;
    protected $table = 'billing';
    protected $primaryKey = 'id';

    protected $fillable = [
    'checkin_id', 
    'guest_name',
    'guest_address', 
    'room_number', 
    'total_amount',
    'invoice_date',
    'due_date',
    'status',
    'created_by'
  ];

  public function checkin(){
    return $this->belongsTo(Checkin::class, 'checkin_id', 'id');
  }
  public function details()
  {
      return $this->hasMany(BillingDetails::class, 'billing_id', 'id');
  }


}
