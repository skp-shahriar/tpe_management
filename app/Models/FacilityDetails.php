<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilityDetails extends Model
{
    use HasFactory;

    public $fillable=[
        'facility_id',
        'employee_id',
        'amount',
        'month',
        'year'
    ];
    public function financialFacility()
    {
        return $this->belongsTo(FinancialFacility::class,'facility_id','id');
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id','id');
    }
}