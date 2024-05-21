<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function customer()
    {
        return $this->belongsTo(customer::class);
    }

    public function item(){
        return $this->hasMany(OrderItem::class);
    }

    protected $fillable = [
        'customer_id',
        'total_amount',
        'discount',
        'total_paid',
    ];
}
