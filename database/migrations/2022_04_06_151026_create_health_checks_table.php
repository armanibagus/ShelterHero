<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHealthChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_checks', function (Blueprint $table) {
            $table->id();
            $table->integer('shelter_id');
            $table->integer('volunteer_id');
            $table->integer('pet_id');
            $table->date('checkup_date');
            $table->string('description', 500);
            $table->enum('status', ['Pending', 'Rejected', 'Accepted'])->default('Pending');
            $table->string('feedback', 500)->nullable();
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
        Schema::dropIfExists('health_checks');
    }
}
