<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            ['id'=>1,'permission_name'=>'dashboard','details'=>NULL,'menu_name'=>'dashboard','route_name'=>'dashboard','status'=>7,'parent_id'=>0,'group_name'=>'master_data','is_menu'=>'yes','serial'=>1],
            ['id'=>2,'permission_name'=>'master_data','details'=>NULL,'menu_name'=>'master_data','route_name'=>'#','status'=>7,'parent_id'=>0,'group_name'=>'master_data','is_menu'=>'yes','serial'=>2],
            ['id'=>3,'permission_name'=>'vendor','details'=>NULL,'menu_name'=>'vendor','route_name'=>'#','status'=>7,'parent_id'=>2,'group_name'=>'master_data','is_menu'=>'yes','serial'=>3],
            ['id'=>4,'permission_name'=>'create_vendor','details'=>NULL,'menu_name'=>'create_vendor','route_name'=>'vendor.create','status'=>7,'parent_id'=>3,'group_name'=>'master_data','is_menu'=>'yes','serial'=>4],
            ['id'=>5,'permission_name'=>'manage_vendor','details'=>NULL,'menu_name'=>'manage_vendor','route_name'=>'vendor.index','status'=>7,'parent_id'=>3,'group_name'=>'master_data','is_menu'=>'yes','serial'=>5],
            ['id'=>6,'permission_name'=>'branch','details'=>NULL,'menu_name'=>'branch','route_name'=>'#','status'=>7,'parent_id'=>2,'group_name'=>'master_data','is_menu'=>'yes','serial'=>6],
            ['id'=>7,'permission_name'=>'create_branch','details'=>NULL,'menu_name'=>'create_branch','route_name'=>'branch.create','status'=>7,'parent_id'=>6,'group_name'=>'master_data','is_menu'=>'yes','serial'=>7],
            ['id'=>8,'permission_name'=>'manage_branch','details'=>NULL,'menu_name'=>'manage_branch','route_name'=>'branch.index','status'=>7,'parent_id'=>6,'group_name'=>'master_data','is_menu'=>'yes','serial'=>8],
            ['id'=>9,'permission_name'=>'option','details'=>NULL,'menu_name'=>'option','route_name'=>'#','status'=>7,'parent_id'=>2,'group_name'=>'master_data','is_menu'=>'yes','serial'=>9],
            ['id'=>10,'permission_name'=>'create_option','details'=>NULL,'menu_name'=>'create_option','route_name'=>'option.create','status'=>7,'parent_id'=>9,'group_name'=>'master_data','is_menu'=>'yes','serial'=>10],
            ['id'=>11,'permission_name'=>'manage_option','details'=>NULL,'menu_name'=>'manage_option','route_name'=>'option.index','status'=>7,'parent_id'=>9,'group_name'=>'master_data','is_menu'=>'yes','serial'=>11],
            ['id'=>12,'permission_name'=>'employee','details'=>NULL,'menu_name'=>'employee','route_name'=>'#','status'=>7,'parent_id'=>2,'group_name'=>'master_data','is_menu'=>'yes','serial'=>12],
            ['id'=>13,'permission_name'=>'create_employee','details'=>NULL,'menu_name'=>'create_employee','route_name'=>'employee.create','status'=>7,'parent_id'=>12,'group_name'=>'master_data','is_menu'=>'yes','serial'=>13],
            ['id'=>14,'permission_name'=>'employee_settings','details'=>NULL,'menu_name'=>'employee_settings','route_name'=>'#','status'=>7,'parent_id'=>12,'group_name'=>'master_data','is_menu'=>'yes','serial'=>14],
            ['id'=>15,'permission_name'=>'employee_action','details'=>NULL,'menu_name'=>'employee_action','route_name'=>'employeeAction','status'=>7,'parent_id'=>14,'group_name'=>'master_data','is_menu'=>'yes','serial'=>15],
            ['id'=>16,'permission_name'=>'manage_employee','details'=>NULL,'menu_name'=>'manage_employee','route_name'=>'employee.index','status'=>7,'parent_id'=>14,'group_name'=>'master_data','is_menu'=>'yes','serial'=>16],
            ['id'=>17,'permission_name'=>'financial_facility','details'=>NULL,'menu_name'=>'financial_facility','route_name'=>'#','status'=>7,'parent_id'=>0,'group_name'=>'financial_facility','is_menu'=>'yes','serial'=>17],
            ['id'=>18,'permission_name'=>'add_financial_facility','details'=>NULL,'menu_name'=>'add_financial_facility','route_name'=>'financial_facility','status'=>7,'parent_id'=>17,'group_name'=>'financial_facility','is_menu'=>'yes','serial'=>18],
            ['id'=>19,'permission_name'=>'financial_facility_report','details'=>NULL,'menu_name'=>'financial_facility_report','route_name'=>'financial_facility_report_form','status'=>7,'parent_id'=>17,'group_name'=>'financial_facility','is_menu'=>'yes','serial'=>19],
        ]);
    }
}