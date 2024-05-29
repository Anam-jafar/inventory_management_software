<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    
    public function salaryHistory(){
        return $this->hasMany(SalaryHistory::class);
    }

    protected $fillable= [
        'customer_id',
        'paid_amount',
        'month',
        'year'
    ];
}
