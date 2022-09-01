<?php

namespace App\Exports;

use App\Models\Attendance;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceExport implements FromCollection,WithHeadings,ShouldAutoSize,WithStyles,WithCustomStartCell,WithDrawings
{
    // public function __construct(array $data) 
    // {
    //     $this->data = $data;
    // }
    public function styles(Worksheet $sheet)
    {
        // $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A5', 'Attendance List');
        $sheet->getStyle('A5')->getFont()->setBold(true);
        $sheet->mergeCells('A5:H5');
        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                // 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'argb' => 'FFA0A0A0',
                ],
                'endColor' => [
                    'argb' => 'FFFFFFFF',
                ],
            ],
        ];
        $sheet->getStyle('A5:H5')->applyFromArray($styleArray);
    }
    public function collection()
    {
            
       $attendanceInfo = DB::table('attendances')
        ->select('attendances.effective_month','attendances.effective_year',
        'branches.branch_name',
        'vendors.vendor_name',
        'employees.employee_id',
        'employees.employee_name',
        'attendances.no_of_shift',
        'attendances.no_of_days'
        )
        ->leftJoin('branches', 'branches.id', '=', 'attendances.branch_id')
        ->leftJoin('vendors', 'vendors.id', '=', 'attendances.vendor_id')
        ->leftJoin('employees', 'employees.id', '=', 'attendances.employee_id')
        ->get(); 
        return $attendanceInfo;
        // return Attendance::select()->where();
    }
    
    public function headings(): array
    {
        return [
            [
            "Effective Month",	
            "Effective Year",	
            "Branch Name",	
            "Vendor Name",	
            "Employee ID",	
            "Employee Name",	
            "Shift Info.",	
            "Absent days"
        ]
    ];
    }
    public function startCell(): string
    {
        return 'A7';
    }
     public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/img/logo/logo.png'));
        $drawing->setHeight(60);    
        // $drawing->setOffsetX(150);
        $drawing->setOffsetY(5);    
        $drawing->setCoordinates('D1');
        return $drawing;
    }
}
