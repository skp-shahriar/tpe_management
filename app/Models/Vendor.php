<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendor extends Model
{
    use HasFactory;
    
    public $fillable=[
        'vendor_name',
        'owner_name',
        'owner_photo',
        'mobile_no',
        'email',
        'address',
        'commission_rate',
        'reference_no',
        'tin',
        'enlisted_date',
        'contact_person',
        'contact_person_number',
        'agreement_attachment',
        'material_commission_amount',
        'agreement_date',
        'status',
        'created_by',
        'updated_by',
    ];
    
    public function setAgreementDateAttribute($value)
    {
        $this->attributes['agreement_date']=Carbon::createFromFormat('d/m/Y',$value)->format('Y-m-d');
    }
    public function setEnlistedDateAttribute($value)
    {
        $this->attributes['enlisted_date']=Carbon::createFromFormat('d/m/Y',$value)->format('Y-m-d');
    }
    public function getAgreementDateAttribute()
    {
        return Carbon::createFromFormat('Y-m-d',$this->attributes['agreement_date'])->format('d/m/Y');
    }
    public function getEnlistedDateAttribute()
    {
        return Carbon::createFromFormat('Y-m-d',$this->attributes['enlisted_date'])->format('d/m/Y');
    }

    public function employee()
    {
        return $this->hasMany(Employee::class);
    }
}