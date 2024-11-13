<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHouseParameterTable extends Migration
{
    public function up()
    {
        Schema::create('house_parameters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parameter_category_id')
                ->nullable()
                ->constrained('house_parameter_categories')
                ->onDelete('cascade');
            $table->foreignId('house_condition_id')
                ->constrained('house_conditions')
                ->onDelete('cascade');
            $table->string('name');
            $table->boolean('value')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->foreignId('updated_by')->nullable()->constrained('users');
        });

    }

    public function down()
    {
        Schema::dropIfExists('house_parameters');
    }
}
