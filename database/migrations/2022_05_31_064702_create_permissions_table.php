<?php

use Database\Seeders\PermissionsSeeder;
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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('permission_name');
            $table->string('details')->nullable();
            $table->string('menu_name');
            $table->string('route_name');
            $table->tinyInteger('status')->comment('1=Pending,2=Approved,3=Resolved,4=Forwarded,5=Deployed,6=New,7=Active,8=Initiated,9=On Progress,10=Delivered,
            11=Locked,12=Returned,13=Sold,14=Paid,20=Settled,21=Replaced,22=Completed,23=Confirmed,24=Honored,-24=Dishonored,25=Accepted
            -1=Deleted,-2=Declined,-3=Canceled,-5=Taking out,-6=Renewed,-7=Inactive;');
            $table->integer('parent_id');
            $table->string('group_name');
            $table->string('is_menu');
            $table->tinyInteger('serial');
            $table->timestamps();
        });

        $seeder = new PermissionsSeeder;
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
};