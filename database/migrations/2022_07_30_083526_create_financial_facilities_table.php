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
        Schema::create('financial_facilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('facility_type')->constrained('options');
            $table->string('process_type');
            $table->string('selective_value')->nullable();
            $table->string('applicable_month');
            $table->string('end_month')->nullable();
            $table->string('amount_type');
            $table->string('amount');
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
        Schema::dropIfExists('financial_facilities');
    }
};