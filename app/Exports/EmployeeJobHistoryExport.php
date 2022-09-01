<?php

namespace App\Exports;

use App\Models\Employee;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EmployeeJobHistoryExport implements ShouldAutoSize,FromView
{
    public function __construct(int $data) 
    {
        $this->data = $data;
    }
    public function view(): View
    {
        $employeeId = $this->data;
        $employeeInfo = Employee::select('employees.*','employee_types.option_value as employee_type_name')
                ->leftJoin('options as employee_types', 'employee_types.id', '=', 'employees.type_id')
                ->where('employees.id',$employeeId)->first();
             
            $employeeJobHistory = DB::table('employee_histories')
            ->leftJoin('branches', 'branches.id', '=', 'employee_histories.branch_id')
            ->leftJoin('options as emp_type', 'emp_type.id', '=', 'employee_histories.employee_type_id')
            ->leftJoin('options as designations', 'designations.id', '=', 'employee_histories.designation_id')
            ->leftJoin('options as departments', 'departments.id', '=', 'employee_histories.department_id')
            ->leftJoin('options as grades', 'grades.id', '=', 'employee_histories.grade_id')            
            ->select('employee_histories.start_date','employee_histories.end_date','employee_histories.salary','branches.branch_name','emp_type.option_value as employee_type_name','designations.option_value as designation_name','departments.option_value as department_name','grades.option_value as grade_name')
            ->where('employee_histories.employee_id', $employeeId)->get();
        return view('reports.employee_job_history_report', [
            'employee_info' => $employeeInfo,
            'employee_job_history' => $employeeJobHistory
        ]);
    }
}