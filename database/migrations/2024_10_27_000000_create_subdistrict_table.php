<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubdistrictTable extends Migration
{
    public function up()
    {
        Schema::create('subdistrict', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subdistrict_name', 255);
            $table->string('subdistrict_code', 255);
            $table->string('district_code', 255);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subdistrict');
    }
}
