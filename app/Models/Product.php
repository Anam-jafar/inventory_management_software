<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function orderitem(){
        return $this->hasMany(OrderItem::class);
    }

    protected $fillable = [
        'name',
        'category_id',
        'price',
        'quantity',
        'restock_limit',
        'description',
        'status'
    ];
}
