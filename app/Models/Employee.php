<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    public function salaries(){
        return $this->hasMany(Salary::class);
    }

    protected $fillable = [
        'name',
        'salary',
        'joined_at',
        'contact',
        'address',
        'nid',
    ];
}
