<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('name');
            $table->date('date_of_birth');
            $table->string('gender');
            $table->string('phone_number');
            $table->string('body_weight')->nullable();
            $table->decimal('fasting_blood_sugar', 5, 2)->nullable(); // Gula Darah Puasa (mg/dL)
            $table->decimal('postprandial_blood_sugar', 5, 2)->nullable(); // Gula Darah 2 jam PP (mg/dL)
            $table->decimal('hba1c', 4, 2)->nullable(); // HbA1c (%)
            $table->decimal('blood_sugar', 5, 2)->nullable(); // Gula Darah
            $table->decimal('cholesterol', 5, 2)->nullable(); // Lemak Darah Kolesterol (mg/dL)
            $table->decimal('hdl', 5, 2)->nullable(); // Lemak Darah HDL (mg/dL)
            $table->decimal('ldl', 5, 2)->nullable(); // Lemak Darah LDL (mg/dL)
            $table->decimal('triglycerides', 5, 2)->nullable(); // Lemak Darah Trigliserida (mg/dL)
            $table->foreignId('health_center_id')->nullable()->constrained('address');
            $table->foreignId('event_id')->nullable()->default(null)->constrained('health_events')->cascadeOnDelete();
            $table->foreignId('address_id')->nullable()->constrained('address');
            $table->foreignId('created_by')->nullable()->default(null)->constrained('users');
            $table->timestamps();
            $table->foreignId('updated_by')->nullable()->constrained('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
