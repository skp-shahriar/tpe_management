<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id');
            $table->string('employee_name');
            $table->string('employee_phone');
            $table->string('employee_email');
            $table->foreignId('vendor_id')->constrained('vendors');
            $table->foreignId('branch_id')->constrained('branches');
            $table->foreignId('region_id')->constrained('options');
            $table->foreignId('division_id')->constrained('options');
            $table->foreignId('department_id')->constrained('options');
            $table->foreignId('designation_id')->constrained('options');
            $table->foreignId('shift_id')->constrained('options');
            $table->foreignId('type_id')->constrained('options');
            $table->integer('present_salary');
            $table->string('service_reference_id');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->foreignId('grade_id')->constrained('options');
            $table->enum('gender', ['Male', 'Female','Others']);
            $table->date('date_of_birth');
            $table->string('marital_status');
            $table->string('religion');
            $table->string('national_id');
            $table->string('tin')->nullable();
            $table->string('reference_info')->nullable();
            $table->enum('under_service_type_packages', ['yes', 'no']);
            $table->string('nationality');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('husband_wife_name')->nullable();
            $table->string('blood_group');
            $table->string('present_address');
            $table->string('permanent_address');
            $table->string('supervisor_name');
            $table->string('manager_name');
            $table->date('joining_date');
            $table->tinyInteger('status')->comment('1=Pending,2=Approved,3=Resolved,4=Forwarded,5=Deployed,6=New,7=Active,8=Initiated,9=On Progress,10=Delivered,
            11=Locked,12=Returned,13=Sold,14=Paid,20=Settled,21=Replaced,22=Completed,23=Confirmed,24=Honored,-24=Dishonored,25=Accepted
            -1=Deleted,-2=Declined,-3=Canceled,-5=Taking out,-6=Renewed,-7=Inactive;');
            $table->tinyInteger('created_by');
            $table->tinyInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};