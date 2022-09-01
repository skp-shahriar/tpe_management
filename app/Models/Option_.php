<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    public $fillable=[
        'group_name',
        'parent_id',
        'option_value',
        'option_value2',
        'option_value3',
        'status',
        'created_by',
        'updated_by',
    ];

    public function region()
    {
        return $this->hasMany(Employee::class);
    }
    public function division()
    {
        return $this->hasMany(Employee::class);
    }
    public function department()
    {
        return $this->hasMany(Employee::class);
    }
    public function designation()
    {
        return $this->hasMany(Employee::class);
    }
    public function shift()
    {
        return $this->hasMany(Employee::class);
    }
    public function type()
    {
        return $this->hasMany(Employee::class);
    }
}