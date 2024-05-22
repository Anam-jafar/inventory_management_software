<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    use HasFactory;
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    protected $fillable = [
        'amount',
        'order_id',
        'customer_id',
    ];
}
