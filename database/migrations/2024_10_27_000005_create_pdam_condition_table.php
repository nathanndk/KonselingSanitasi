<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePdamConditionTable extends Migration
{
    public function up()
    {
        Schema::create('pdam_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->nullable()->constrained('health_events')->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pdam_conditions');
    }
}
