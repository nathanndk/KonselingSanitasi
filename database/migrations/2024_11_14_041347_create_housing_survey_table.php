<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\WaterSource;
use App\Enums\EducationLevel;
use App\Enums\JobType;
use App\Enums\HouseOwnership;

class CreateHousingSurveyTable extends Migration
{
    public function up()
    {
        Schema::create('housing_surveys', function (Blueprint $table) {
            $table->id();
            $table->date('sampling_date')->nullable();
            $table->string('diagnosed_disease', 100)->nullable(); // Batas 100 karakter
            $table->string('head_of_family', 50)->nullable(); // Batas 50 karakter
            $table->enum('drinking_water_source', array_column(WaterSource::cases(), 'value'))->nullable();
            $table->enum('clean_water_source', array_column(WaterSource::cases(), 'value'))->nullable();
            $table->enum('last_education', array_column(EducationLevel::cases(), 'value'))->nullable();
            $table->enum('job', array_column(JobType::cases(), 'value'))->nullable();
            $table->integer('family_members')->nullable();
            $table->enum('house_ownership', array_column(HouseOwnership::cases(), 'value'))->nullable();
            $table->string('house_area', 10)->nullable(); // Batas 10 karakter
            $table->boolean('landslide_prone')->default(false)->nullable();
            $table->boolean('garbage_site_nearby')->default(false)->nullable();
            $table->boolean('high_voltage_area')->default(false)->nullable();
            $table->boolean('roof_quality')->default(false)->nullable();
            $table->boolean('ceiling_quality')->default(false)->nullable();
            $table->boolean('wall_quality')->default(false)->nullable();
            $table->boolean('bedroom_condition')->default(false)->nullable();
            $table->boolean('public_room_condition')->default(false)->nullable();
            $table->boolean('floor_condition')->default(false)->nullable();
            $table->boolean('ventilation')->default(false)->nullable();
            $table->boolean('lighting')->default(false)->nullable();
            $table->boolean('drinking_water_available')->default(false)->nullable();
            $table->boolean('toilet_available')->default(false)->nullable();
            $table->boolean('ctps_facility')->default(false)->nullable();
            $table->boolean('trash_management')->default(false)->nullable();
            $table->boolean('liquid_waste_management')->default(false)->nullable();
            $table->boolean('livestock_pen_separate')->default(false)->nullable();
            $table->decimal('noise_level', 5, 2)->nullable();
            $table->decimal('humidity', 5, 2)->nullable();
            $table->decimal('illumination', 5, 2)->nullable();
            $table->decimal('ventilation_rate', 5, 2)->nullable();
            $table->decimal('room_temperature', 5, 2)->nullable();
            $table->decimal('water_ph', 5, 2)->nullable();
            $table->decimal('water_temperature', 5, 2)->nullable();
            $table->decimal('water_tds', 5, 2)->nullable();
            $table->integer('score')->nullable();
            $table->decimal('houseworthiness_score', 5, 2)->nullable();
            $table->string('houseworthiness_status', 20)->nullable(); // Batas 20 karakter
            $table->decimal('sanitation_score', 5, 2)->nullable();
            $table->string('sanitation_status', 20)->nullable(); // Batas 20 karakter
            $table->decimal('behavior_score', 5, 2)->nullable();
            $table->string('behavior_status', 20)->nullable(); // Batas 20 karakter
            $table->text('notes')->nullable();
            $table->foreignId('patient_id')->nullable()->constrained('patients')->onDelete('cascade');
            $table->foreignId('event_id')->nullable()->constrained('health_events')->cascadeOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('housing_surveys');
    }
}
