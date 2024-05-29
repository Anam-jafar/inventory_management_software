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
    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    protected $fillable= [
        'employee_id',
        'paid_amount',
        'month',
        'year'
    ];
}