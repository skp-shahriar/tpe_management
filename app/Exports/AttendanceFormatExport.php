<?php
namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithBackgroundColor;

class AttendanceFormatExport implements FromView, WithBackgroundColor, ShouldAutoSize
{

    public function __construct(array $data) 
    {
        $this->data = $data;
    }

    public function view(): View
    {

        $employeeInfo = DB::table('employees')            
            ->leftJoin('branches', 'branches.id', '=', 'employees.branch_id')
            ->leftJoin('vendors', 'vendors.id', '=', 'employees.vendor_id')
            ->select('employees.employee_id', 'employees.employee_name','branches.branch_name','vendors.vendor_name')
            // ->where('employees.employee_id',$row[4])
            ->get(); 
        #dd($employeeInfo);
        return view('attendance.attendance_format_export', [
            'import_month' => $this->data["year"],
            'import_year' => $this->data["month_id"],
            'employees' => $employeeInfo
        ]);
    }
    
    public function backgroundColor()
    {
        // Return RGB color code.
        // return '000000';
    
        // Return a Color instance. The fill type will automatically be set to "solid"
        //    return new Color(Color::COLOR_YELLOW);
    
        // Or return the styles array
        // return [
        //      'fillType'   => Fill::FILL_GRADIENT_LINEAR,
        //      'startColor' => ['argb' => Color::COLOR_CYAN],
        // ];
    }
}