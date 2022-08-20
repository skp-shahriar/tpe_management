<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialFacility extends Model
{
    use HasFactory;

    public $fillable=[
        'facility_type',
        'process_type',
        'selective_value',
        'applicable_month',
        'end_month',
        'amount_type',
        'amount',
        'created_by',
        'updated_by',
    ];
    public function facilityDetails()
    {
        return $this->hasMany(facilityDetails::class);
    }
}