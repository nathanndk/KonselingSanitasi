<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressTable extends Migration
{
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('street');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('subdistrict_id');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('district_id')
                  ->references('id')
                  ->on('district')
                  ->onDelete('cascade');

            $table->foreign('subdistrict_id')
                  ->references('id')
                  ->on('subdistrict')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('address');
    }
}
