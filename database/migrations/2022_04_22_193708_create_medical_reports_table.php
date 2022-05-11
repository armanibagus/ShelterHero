<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_reports', function (Blueprint $table) {
            $table->id();
            $table->integer('health_check_id');
            $table->string('allergies');
            $table->string('existing_condition');
            $table->string('vaccination')->nullable();
            $table->string('diagnosis');
            $table->string('test_performed');
            $table->string('test_result');
            $table->string('action');
            $table->string('medication');
            $table->string('comments', 500);
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
        Schema::dropIfExists('medical_reports');
    }
}
