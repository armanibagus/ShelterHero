<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdoptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adoptions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('shelter_id');
            $table->integer('pet_id');
            $table->string('user_idNumber');
            $table->string('name');
            $table->string('adopter_age');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('postal');
            $table->string('occupation');
            $table->decimal('salary', 19, 2);
            $table->integer('no_of_pet_owned');
            $table->string('pets_description', 300);
            $table->enum('home_question', ['Owned', 'Rent']);
            $table->string('rent_time')->nullable();
            $table->string('animal_permission')->nullable();
            $table->enum('rehomed_question', ['Yes', 'No']);
            $table->string('rehomed_description', 300)->nullable();
            $table->string('family_member');
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
        Schema::dropIfExists('adoptions');
    }
}
