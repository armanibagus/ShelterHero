<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaimImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claim_images', function (Blueprint $table) {
            $table->id();
            $table->integer('claim_id')->nullable();
            $table->string('title');
            $table->string('path');
            $table->enum('type', ['proof_of_img', 'birth_certificate_img', 'appropriate_img']);
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
        Schema::dropIfExists('claim_images');
    }
}
