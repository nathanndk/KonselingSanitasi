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
            $table->string('kc_code'); // district code
            $table->string('p_code');  // subdistrict code
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('kc_code')
                  ->references('district_code')
                  ->on('district')
                  ->onDelete('cascade');

            $table->foreign('p_code')
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
