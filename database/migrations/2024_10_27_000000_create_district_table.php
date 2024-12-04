<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistrictTable extends Migration
{
    public function up()
    {
        Schema::create('district', function (Blueprint $table) {
            $table->string('district_code', 5)->primary();
            $table->string('district_name', 50);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('district');
    }
}

