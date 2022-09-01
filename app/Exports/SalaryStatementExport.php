<?php
namespace App\Exports;

use App\Models\Configuration;
use App\Models\Employee;
use App\Models\Payment_deduction;
use App\Models\SalaryComponent;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
// use Maatwebsite\Excel\Concerns\WithBackgroundColor;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;

class SalaryStatementExport implements FromView, /*WithBackgroundColor, */ShouldAutoSize, WithDrawings, WithEvents
{

    public function __construct(array $data) 
    {
        $this->data = $data;
    }
  public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/img/logo/logo.png'));
        $drawing->setHeight(60);        
        $drawing->setCoordinates('G1');
        // $drawing->setOffsetX(150);
        $drawing->setOffsetY(5);
        return $drawing;
    }
    public function view(): View
    {
        $reportMonth = $this->data['month'];
        $reportYear = $this->data['year'];
        DB::enableQueryLog();
        $query = DB::table('employees')            
            ->leftJoin('branches', 'branches.id', '=', 'employees.branch_id')
            ->leftJoin('vendors', 'vendors.id', '=', 'employees.vendor_id')
            ->leftJoin('options', 'options.id', '=', 'employees.designation_id')
            ->select('employees.employee_id', 
            'employees.branch_id',
            'employees.employee_name',
            'employees.joining_date',
            'employees.service_reference_id',
            'employees.present_salary',
            'employees.vendor_id',
            'branches.branch_name',
            'vendors.vendor_name',
            'vendors.commission_rate',
            'options.option_value as designation_name',
            DB::raw("(SELECT attendances.no_of_shift FROM attendances WHERE attendances.employee_id = employees.id AND effective_month = $reportMonth AND effective_year = $reportYear LIMIT 1) as no_of_shift"),
            DB::raw("(SELECT attendances.no_of_days FROM attendances WHERE attendances.employee_id = employees.id AND effective_month = $reportMonth AND effective_year = $reportYear LIMIT 1) as no_of_day_adsent")
        );
        $query->where('employees.vendor_id',$this->data['vendor_id']);
        if($this->data['branch_id'] != 'all'){
            $query->where('employees.vendor_id',$this->data['branch_id']);
        }        
        $result = $query->get(); 
        $customResult = array();
        foreach($result as $val):
            $branchId = $val->branch_id ? $val->branch_id : 'not_assigned';
            $customResult[$branchId]['branch_name'] = $val->branch_name;
            $customResult[$branchId]['emp_records'][] = $val;
        endforeach;
        $salaryStatements = $customResult;
        #dd(DB::getQueryLog());
        #dd($salaryStatements);
        
        $taxRate = Configuration::where('id',1)->value('value');
        $vatRate = Configuration::where('id',2)->value('value');
        $paymentDeductionInfo = Payment_deduction::select('reason','amount')->where(['effective_year'=>2022,'effective_month'=>7,'vendor_id'=>1])->first();
        
        return view('reports.salary_statement_export', [
            'vat_rate' => $vatRate,
            'tax_rate' => $taxRate,
            'payment_deduction_info' => $paymentDeductionInfo,
            'salary_statements' => $salaryStatements
        ]);
    }
    use RegistersEventListeners;

    public static function afterSheet(AfterSheet $event)
    {
        $sheet = $event->sheet->getDelegate();

        // $sheet->getStyle('1')->getFont()->setSize(16);
        $sheet->getStyle('A1:O2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF');
        // ...
    }
    
    // public function backgroundColor()
    // {
    //     // Return RGB color code.
    //     // return '000000';
    
    //     // Return a Color instance. The fill type will automatically be set to "solid"
    // //    return new Color(Color::COLOR_YELLOW);
    
    //     // Or return the styles array
    //     // return [
    //     //      'fillType'   => Fill::FILL_GRADIENT_LINEAR,
    //     //      'startColor' => ['argb' => Color::COLOR_CYAN],
    //     // ];
    // }
}