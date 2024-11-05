<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCounselingReportTable extends Migration
{
    public function up()
    {
        Schema::create('counseling_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients');
            $table->date('counseling_date');
            $table->foreignId('address_id')->constrained('address');
            $table->foreignId('sanitation_condition_id')->constrained('sanitation_conditions');
            $table->string('recommendation');
            $table->date('house_visit_date')->nullable();
            $table->string('intervention')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->foreignId('updated_by')->nullable()->constrained('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('counseling_reports');
    }
}
