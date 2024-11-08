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
            $table->string('kc_code');
            $table->string('p_code');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('health_centers');
    }
}
