<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number');
            $table->string('identification_number')->nullable();
            $table->string('title');
            $table->string('authors');
            $table->string('cover_page');
            $table->string('digital_version')->nullable();
            $table->integer('copies_number');
            $table->integer('available_number');
            $table->integer('page_number');
            $table->boolean('status')->default(true);
            $table->text('keywords');
            $table->string('ray')->nullable();
            $table->string('edition')->nullable();
            $table->timestamps();

            $table->foreignId('sub_category_id')->constrained();
            $table->foreignId('type_id')->constrained();
            $table->foreignId('institute_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resources');
    }
}
