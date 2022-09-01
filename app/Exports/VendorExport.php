<?php

namespace App\Exports;

use App\Models\Option;
use Illuminate\Support\Facades\Redis;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class VendorExport implements FromCollection,WithHeadings,ShouldAutoSize
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
                "vendor_name",                                                                                                                                                                                   
                "owner_name",                                                                                                                                                                                   
                "mobile_no",                                                                                                                                                                                            
                "email",
                "address",                                                                                                                                                                                          
                "commission_rate",                                                                                                                                                                                         
                "reference_no",
                "tin",
                "enlisted_date",
                "contact_person",
                "contact_person_number",
                "material_commission_amount",
                "agreement_date",
                // "created_by",                                                                                                                                                                                                                                                                                                                                               
                // "updated_by",                                                                                                                                                                                                                                                                                                                                               
                // "created_at",                                                                                                                                                                                                                                                                                                                                               
                // "updated_at" 
        ]
    ];
    }
}