<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSanitationConditionTable extends Migration
{
    public function up()
    {
        Schema::create('sanitation_conditions', function (Blueprint $table) {
            $table->id();
            $table->date('counseling_date')->nullable();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->string('condition')->nullable();
            $table->string('recommendation')->nullable();
            $table->date('home_visit_date')->nullable();
            $table->string('intervention')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('event_id')->nullable()->constrained('health_events')->cascadeOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sanitation_conditions');
    }
}
