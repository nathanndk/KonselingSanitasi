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
            $table->string('street', 255)->nullable();
            $table->string('district_code', 5)->nullable();
            $table->string('subdistrict_code', 5)->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('district_code')
                  ->references('district_code')
                  ->on('district')
                  ->onDelete('cascade');

            $table->foreign('subdistrict_code')
                  ->references('subdistrict_code')
                  ->on('subdistrict')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('address');
    }
}
