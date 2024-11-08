<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePdamParameterTable extends Migration
{
    public function up()
    {
        Schema::create('pdam_parameters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parameter_category_id')->nullable();
            $table->foreign('parameter_category_id')
                  ->references('id')
                  ->on('pdam_parameter_categories')
                  ->onDelete('cascade');

            $table->foreignId('condition_id')->nullable()->constrained('pdam_conditions')->onDelete('cascade');
            $table->string('name');
            $table->string('value')->nullable()->default(null);
            // $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pdam_parameters');
    }
}
