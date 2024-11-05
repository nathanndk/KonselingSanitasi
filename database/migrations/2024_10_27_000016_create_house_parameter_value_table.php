<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHouseParameterValueTable extends Migration
{
    public function up()
    {
        Schema::create('house_parameter_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parameter_id')->constrained('house_parameters');
            $table->foreignId('house_condition_id')->constrained('house_conditions');
            $table->float('value');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->foreignId('updated_by')->nullable()->constrained('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('house_parameter_values');
    }
}
