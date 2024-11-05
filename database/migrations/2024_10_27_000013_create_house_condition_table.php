<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHouseConditionTable extends Migration
{
    public function up()
    {
        Schema::create('house_conditions', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->foreignId('updated_by')->nullable()->constrained('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('house_conditions');
    }
}
