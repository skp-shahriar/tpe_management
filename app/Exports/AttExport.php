<?php

namespace App\Exports;

use App\Models\SalaryComponent;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// use Maatwebsite\Excel\Concerns\WithDrawings;
// use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalaryExport implements FromCollection,ShouldAutoSize/*,WithDrawings*/,WithHeadings
{
    public function __construct(array $data) 
    {
        $this->data = $data;
    }
    public function headings(): array
    {
        return [
            'SL No.',
            'Name',
            'Position',
            'Joining Date',
            'Service Reference No.',
            'Salary',
            'Commission',
            'Total',
            'VAT',
            'Grand Total',
            'Tax',
            'Net Amount Payable',
            'A/C Number'
        ];
    }

    public function collection()
    {
        
        #dd($this->data);
        return SalaryComponent::all();
    }

    // public function drawings()
    // {
    //     $drawing = new Drawing();
    //     $drawing->setName('Logo');
    //     $drawing->setDescription('This is my logo');
    //     $drawing->setPath(public_path('/img/logo/logo.png'));
    //     $drawing->setHeight(60);        
    //     $drawing->setCoordinates('A1');
    //     return $drawing;
    // }
}