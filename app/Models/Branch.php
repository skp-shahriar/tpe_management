<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    public $fillable=[
        'branch_code',
        'branch_name',
        'branch_type',
        'address',
        'status',
        'created_by',
        'updated_by',
    ];

    public function employee()
    {
        return $this->hasMany(Employee::class);
    }
}