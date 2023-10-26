<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanResourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_resource', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('loan_id');
            $table->unsignedBigInteger('resource_id');

            $table->foreign('loan_id')->references('id')->on('loans');
            $table->foreign('resource_id')->references('id')->on('resources');

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
        Schema::dropIfExists('loan_resource');
    }
}
