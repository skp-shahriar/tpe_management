<?php

namespace App\Exports;

use Illuminate\Support\Facades\Redis;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EmployeeExport implements FromCollection,WithHeadings,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(object $data) 
    {       
        $this->data = $data;
    }
    
    public function collection()
    {
        ini_set('memory_limit', '2024M');    
        ini_set('max_execution_time',0); // 5*60 = 5 min 
        // $groupName = $this->data['group_name'];
        // $searchText = $this->data['search_text'];
        
        return $this->data;
        // $startTime = microtime(true);
        // $cacheOptions = Redis::get('options');
        // $endTime = microtime(true);
        // $executionTime = $endTime - $startTime;
        // if(isset($cacheOptions)){
        //     $options = json_decode($cacheOptions);
        // }else{
        //     $startTime = microtime(true);
        //     $options = Option::all();
        //     Redis::set('options',json_encode($options));
        //     $endTime = microtime(true);
        //     $executionTime = $endTime - $startTime;
        // }
        // dd($executionTime);
        // return collect($options);
        // return Option::limit(270000)->get();
    }
    public function headings(): array
    {
        return [
            [
                "id",                                                                                                                                                                                                                                                                                                                                            
                "employee_id",                                                                                                                                                                                   
                "employee_name",                                                                                                                                                                                            
                "employee_phone",                                                                                                                                                                                          
                "employee_email", 
                "present_salary",
                "service_reference_id",
                "start_date",
                "gender",
                "date_of_birth",
                "marital_status",
                "religion",
                "national_id",
                "tin",
                "reference_info",
                "under_service_type_packages",
                "nationality",
                "father_name",
                "mother_name",
                "husband_wife_name",
                "blood_group",
                "present_address",
                "permanent_address",
                "supervisor_name",
                "manager_name",
                "joining_date",
                // "created_by",                                                                                                                                                                                                                                                                                                                                               
                // "updated_by",                                                                                                                                                                                                                                                                                                                                               
                // "created_at",                                                                                                                                                                                                                                                                                                                                               
                // "updated_at" 
        ]
    ];
    }
}