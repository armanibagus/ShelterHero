<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('shelter_id')->nullable();
            $table->string('nickname');
            $table->enum('petType', ['Dog','Cat','Bird','Rabbit', 'Fish']);
            $table->enum('sex', ['Male','Female']);
            $table->integer('age');
            $table->enum('size', ['small', 'medium', 'large']);
            $table->decimal('weight');
            $table->string('condition', 500);
            $table->enum('status', ['Pending', 'Picked Up', 'Confirmed'])->default('Pending');
            $table->date('pickUpDate')->nullable();
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
        Schema::dropIfExists('pets');
    }
}
