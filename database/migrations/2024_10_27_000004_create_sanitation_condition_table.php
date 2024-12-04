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
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->date('sampling_date');
            $table->string('condition', 1000)->nullable();
            $table->string('recommendation', 1000)->nullable();
            $table->string('intervention', 1000)->nullable();
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
