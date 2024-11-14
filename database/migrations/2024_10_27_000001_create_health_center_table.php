<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHealthCenterTable extends Migration
{
    public function up()
    {
        Schema::create('health_centers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('district_code', 255); // Menggunakan string sesuai kolom di tabel district
            $table->string('subdistrict_code', 255); // Menggunakan string sesuai kolom di tabel subdistrict
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
        Schema::dropIfExists('health_centers');
    }
}
