<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLostPetClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lost_pet_claims', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('shelter_id');
            $table->integer('pet_id');
            $table->string('user_idNumber');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('postal');
            $table->string('other_information', 300);
            $table->enum('status', ['Pending', 'Rejected', 'Accepted'])->default('Pending');
            $table->date('delivery_date')->nullable();
            $table->string('feedback', 300)->nullable();
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
        Schema::dropIfExists('lost_pet_claims');
    }
}
