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
            $table->unsignedBigInteger('address_id')->nullable(); // Ensure this matches the type of `id` in `address`
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('address_id')
                  ->references('id')
                  ->on('address')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('health_centers');
    }
}
