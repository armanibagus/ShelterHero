<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->integer('shelter_id');
            $table->string('user_idNumber');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('postal');
            $table->string('bank_name');
            $table->string('accountName');
            $table->string('CCNumber');
            $table->string('title');
            $table->decimal('amount_need', 19, 2);
            $table->decimal('amount_get', 19, 2)->default('0');
            $table->date('expiry_date');
            $table->string('purpose');
            $table->string('donation_recipient');
            $table->string('description', 500);
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
        Schema::dropIfExists('donations');
    }
}
