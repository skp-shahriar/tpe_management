<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasFactory;
    
    public $fillable=[
        'employee_id',
        'employee_name',
        'employee_phone',
        'employee_email',
        'vendor_id',
        'branch_id',
        'region_id',
        'division_id',
        'department_id',
        'designation_id',
        'shift_id',
        'type_id',
        'start_date',
        'end_date',
        'grade_id',
        'present_salary',
        'service_reference_id',
        'gender',
        'date_of_birth',
        'marital_status',
        'religion',
        'national_id',
        'tin',
        'reference_info',
        'under_service_type_packages',
        'nationality',
        'father_name',
        'mother_name',
        'husband_wife_name',
        'blood_group',
        'present_address',
        'permanent_address',
        'supervisor_name',
        'manager_name',
        'joining_date',
        'status',
        'created_by',
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
    public function setDateOfBirthAttribute($value)
    {
        $this->attributes['date_of_birth']=Carbon::createFromFormat('d/m/Y',$value)->format('Y-m-d');
    }
    public function setJoiningDateAttribute($value)
    {
        $this->attributes['joining_date']=Carbon::createFromFormat('d/m/Y',$value)->format('Y-m-d');
    }
    
    
    public function getStartDateAttribute()
    {
        if ($this->attributes['start_date']!=null) {
            return Carbon::createFromFormat('Y-m-d',$this->attributes['start_date'])->format('d/m/Y');
        }
    }
    public function getEndDateAttribute()
    {
        if ($this->attributes['end_date']!=null) {
            return Carbon::createFromFormat('Y-m-d',$this->attributes['end_date'])->format('d/m/Y');
        }
    }
    public function getDateOfBirthAttribute()
    {
        return Carbon::createFromFormat('Y-m-d',$this->attributes['date_of_birth'])->format('d/m/Y');
    }
    public function getJoiningDateAttribute()
    {
        return Carbon::createFromFormat('Y-m-d',$this->attributes['joining_date'])->format('d/m/Y');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
    public function region()
    {
        return $this->belongsTo(Option::class, 'region_id','id');
    }
    public function division()
    {
        return $this->belongsTo(Option::class, 'division_id','id');
    }
    public function department()
    {
        return $this->belongsTo(Option::class, 'department_id','id');
    }
    public function designation()
    {
        return $this->belongsTo(Option::class, 'designation_id','id');
    }
    public function shift()
    {
        return $this->belongsTo(Option::class, 'shift_id','id');
    }
    public function type()
    {
        return $this->belongsTo(Option::class, 'type_id','id');
    }
    public function grade()
    {
        return $this->belongsTo(Option::class, 'grade_id','id');
    }

    public function employeeHistory()
    {
        return $this->hasMany(EmployeeHistory::class);
    }
    public function facilityDetails()
    {
        return $this->hasMany(FacilityDetails::class);
    }
}