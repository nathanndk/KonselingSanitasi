<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePdamParameterValueTable extends Migration
{
    public function up()
    {
        Schema::create('pdam_parameter_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parameter_id')->constrained('pdam_parameters');
            $table->float('value')->nullable(); // Membuat kolom value bisa nullable
            $table->foreignId('pdam_condition_id')->nullable()->constrained('pdam_conditions')->onDelete('cascade');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('pdam_parameter_values');
    }
}
