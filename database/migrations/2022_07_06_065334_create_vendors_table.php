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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('vendor_name',100);
            $table->string('owner_name',100);
            $table->string('owner_photo');
            $table->string('mobile_no',20);
            $table->string('email',100);
            $table->string('address',200);
            $table->float('commission_rate')->nullable();
            $table->string('reference_no',100)->nullable();
            $table->string('tin');
            $table->date('enlisted_date');
            $table->string('contact_person',200)->nullable();
            $table->string('contact_person_number',200)->nullable();
            $table->string('agreement_attachment',200);
            $table->float('material_commission_amount')->nullable();
            $table->date('agreement_date');
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
        Schema::dropIfExists('vendors');
    }
};