<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FinancialFacilityController;
use App\Http\Controllers\OptionController;
use App\lib\Webspice;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => ['auth']], function() {
    Route::get('active-inactive', [Webspice::class, 'activeInactive'])->name('active.inactive');
    Route::post('financialFacilityGenerateReport', [FinancialFacilityController::class, 'generateReport']);
    Route::get('financialFacilityReportGetBranch', [FinancialFacilityController::class, 'getBranch']);
    Route::get('financialFacilityReportForm', [FinancialFacilityController::class, 'financialFacilityReportForm'])->name('financial_facility_report_form');
    Route::post('addFinancialFacility', [FinancialFacilityController::class, 'addFinancialFacility']);
    Route::get('getSelectiveValue', [FinancialFacilityController::class, 'getSelectiveValue']);
    Route::get('financialFacilityManage', [FinancialFacilityController::class, 'financialFacility'])->name('financial_facility');
    Route::post('employee/empHistory', [EmployeeController::class, 'empHistory'])->name('empHistory');
    Route::post('employee/currentValue', [EmployeeController::class, 'currentValue'])->name('currentValue');
    Route::get('employee/employeeAction', [EmployeeController::class, 'employeeAction'])->name('employeeAction');
    Route::post('employee/findEmployeeType', [EmployeeController::class, 'findEmployeeType']);
    Route::get('option/parentDropDown', [OptionController::class, 'parentDropDown']);
    Route::post('vendor/statusSwitch', [VendorController::class, 'statusSwitch']);
    Route::get('vendor/fetchVendorTable', [VendorController::class, 'fetchVendorTable']);
    Route::resources([
        'employee' => EmployeeController::class,
        'option' => OptionController::class,
        'branch' => BranchController::class,
        'vendor' => VendorController::class,
    ]);
    Route::get('/', [UserController::class,'index'])->name('dashboard');
});