<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['id'=>'1','role_name'=>'Super Admin','details'=>NULL,'permission_name'=>'dashboard,master_data,vendor,create_vendor,manage_vendor,branch,create_branch,manage_branch,option,create_option,manage_option,employee,create_employee,employee_settings,employee_action,manage_employee,financial_facility,add_financial_facility,financial_facility_report','status'=>7],
            ['id'=>'2','role_name'=>'Admin','details'=>NULL,'permission_name'=>'','status'=>7],
            ['id'=>'3','role_name'=>'General','details'=>NULL,'permission_name'=>'dashboard,master_data,vendor,create_vendor,manage_vendor,branch,create_branch,manage_branch,option,create_option,manage_option,employee,create_employee,employee_settings,employee_action,manage_employee,financial_facility,add_financial_facility,financial_facility_report','status'=>7]
        ]);
    }
}