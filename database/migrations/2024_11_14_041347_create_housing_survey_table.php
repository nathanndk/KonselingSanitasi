<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHousingSurveyTable extends Migration
{
    public function up()
    {
        Schema::create('housing_surveys', function (Blueprint $table) {
            $table->id();
            $table->date('sampling_date')->nullable();
            $table->string('diagnosed_disease', 100)->nullable(); // Batas 100 karakter
            $table->string('head_of_family', 50)->nullable(); // Batas 50 karakter
            $table->string('drinking_water_source')->nullable(); // Kolom string
            $table->string('clean_water_source')->nullable(); // Kolom string
            $table->string('last_education')->nullable(); // Kolom string
            $table->string('job')->nullable(); // Kolom string
            $table->integer('family_members')->nullable(); // Kolom integer
            $table->string('house_ownership')->nullable(); // Kolom string
            $table->string('house_area', 10)->nullable(); // Batas 10 karakter

            // Kolom boolean berdasarkan daftar yang diberikan
            $table->boolean('landslide_prone')->default(false)->nullable(); // Kolom boolean
            $table->boolean('garbage_site_nearby')->default(false)->nullable(); // Kolom boolean
            $table->boolean('high_voltage_area')->default(false)->nullable(); // Kolom boolean
            $table->boolean('roof_strong_no_leak')->default(false)->nullable(); // Kolom boolean
            $table->boolean('roof_drainage')->default(false)->nullable(); // Kolom boolean
            $table->boolean('ceiling_strong_safe')->default(false)->nullable(); // Kolom boolean
            $table->boolean('ceiling_clean_no_dust')->default(false)->nullable(); // Kolom boolean
            $table->boolean('ceiling_flat_adequate_air')->default(false)->nullable(); // Kolom boolean
            $table->boolean('ceiling_clean_condition')->default(false)->nullable(); // Kolom boolean
            $table->boolean('wall_strong_waterproof')->default(false)->nullable(); // Kolom boolean
            $table->boolean('wall_smooth_no_cracks')->default(false)->nullable(); // Kolom boolean
            $table->boolean('wall_no_dust_easy_clean')->default(false)->nullable(); // Kolom boolean
            $table->boolean('wall_bright_color')->default(false)->nullable(); // Kolom boolean
            $table->boolean('wall_clean_condition')->default(false)->nullable(); // Kolom boolean
            $table->boolean('bedroom_clean_condition')->default(false)->nullable(); // Kolom boolean
            $table->boolean('bedroom_lighting')->default(false)->nullable(); // Kolom boolean
            $table->boolean('bedroom_area_minimum')->default(false)->nullable(); // Kolom boolean
            $table->boolean('ceiling_height_minimum')->default(false)->nullable(); // Kolom boolean
            $table->boolean('general_room_no_hazardous_materials')->default(false)->nullable(); // Kolom boolean
            $table->boolean('general_room_safe_easily_cleaned')->default(false)->nullable(); // Kolom boolean
            $table->boolean('floor_waterproof')->default(false)->nullable(); // Kolom boolean
            $table->boolean('floor_smooth_no_cracks')->default(false)->nullable(); // Kolom boolean
            $table->boolean('safe_drinking_water_source')->default(false)->nullable(); // Kolom boolean
            $table->boolean('drinking_water_location')->default(false)->nullable(); // Kolom boolean
            $table->boolean('toilet_usage')->default(false)->nullable(); // Kolom boolean
            $table->boolean('own_toilet')->default(false)->nullable(); // Kolom boolean
            $table->boolean('ctps_facility')->default(false)->nullable(); // Kolom boolean
            $table->boolean('ctps_accessibility')->default(false)->nullable(); // Kolom boolean
            $table->boolean('bedroom_window_open')->default(false)->nullable(); // Kolom boolean
            $table->boolean('living_room_window_open')->default(false)->nullable(); // Kolom boolean
            $table->boolean('noise_level')->default(false)->nullable(); // Kolom boolean
            $table->boolean('humidity')->default(false)->nullable(); // Kolom boolean
            $table->text('notes')->nullable(); // Kolom string

            // Foreign Keys
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
