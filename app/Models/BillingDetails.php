<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingDetails extends Model
{
    use HasFactory;
    protected $table = 'billingdetails';
    protected $primaryKey = 'id';

    protected $fillable = [
    'billing_id', 
    'description',
    'invoice_date', 
    'due_date', 
    'unit_price',
    'quantity',
    'discount',
    'tax',
    'total_amount'
  ];

  public function billing(){
    return $this->belongsTo(Billing::class, 'billing_id', 'id');
  }
    
}
