<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHouseParameterCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('house_parameter_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            // Relasi ke users untuk created_by dan updated_by
            $table->foreignId('updated_by')->nullable()->constrained('users');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('house_parameter_categories');
    }
}
