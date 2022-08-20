<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeHistory extends Model
{
    use HasFactory;

    public $fillable=[
        'employee_id',
        'start_date',
        'end_date',
        'branch_id',
        'employee_type_id',
        'designation_id',
        'department_id',
        'grade_id',
        'action_type',
        'updated_by',
    ];

    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date']=Carbon::createFromFormat('d/m/Y',$value)->format('Y-m-d');
    }
    public function setEndDateAttribute($value)
    {
        $this->attributes['end_date']=Carbon::createFromFormat('d/m/Y',$value)->format('Y-m-d');
    }

    public function getStartDateAttribute()
    {
        return Carbon::createFromFormat('Y-m-d',$this->attributes['start_date'])->format('d/m/Y');
    }
    public function getEndDateAttribute()
    {
        return Carbon::createFromFormat('Y-m-d',$this->attributes['end_date'])->format('d/m/Y');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}