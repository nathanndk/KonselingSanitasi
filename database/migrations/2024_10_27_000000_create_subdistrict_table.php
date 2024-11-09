<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubdistrictTable extends Migration
{
    public function up()
    {
        Schema::create('subdistrict', function (Blueprint $table) {
            $table->string('subdistrict_code', 255)->primary();
            $table->string('subdistrict_name', 255);
            $table->string('district_code', 255);
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('district_code')
                  ->references('district_code')
                  ->on('district')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('subdistrict');
    }
}
