<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryHistory extends Model
{
    use HasFactory;

    public function salary()
    {
        return $this->belongsTo(Salary::class);
    }

    protected $fillable = [ 
        'amount'
    ];
}
