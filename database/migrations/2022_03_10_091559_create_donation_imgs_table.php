<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationImgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donation_imgs', function (Blueprint $table) {
            $table->id();
            $table->integer('donation_id')->nullable();
            $table->integer('donate_id')->nullable();
            $table->string('title');
            $table->string('path');
            $table->enum('type', ['donation', 'donate']);
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
        Schema::dropIfExists('donation_imgs');
    }
}
