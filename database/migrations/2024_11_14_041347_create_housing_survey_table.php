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
            $table->boolean('landslide_prone')->nullable(); // Kolom boolean
            $table->boolean('garbage_site_nearby')->nullable(); // Kolom boolean
            $table->boolean('high_voltage_area')->nullable(); // Kolom boolean
            $table->boolean('roof_strong_no_leak')->nullable(); // Kolom boolean
            $table->boolean('roof_drainage')->nullable(); // Kolom boolean
            $table->boolean('ceiling_strong_safe')->nullable(); // Kolom boolean
            $table->boolean('ceiling_clean_no_dust')->nullable(); // Kolom boolean
            $table->boolean('ceiling_flat_adequate_air')->nullable(); // Kolom boolean
            $table->boolean('ceiling_clean_condition')->nullable(); // Kolom boolean
            $table->boolean('wall_strong_waterproof')->nullable(); // Kolom boolean
            $table->boolean('wall_smooth_no_cracks')->nullable(); // Kolom boolean
            $table->boolean('wall_no_dust_easy_clean')->nullable(); // Kolom boolean
            $table->boolean('wall_bright_color')->nullable(); // Kolom boolean
            $table->boolean('wall_clean_condition')->nullable(); // Kolom boolean
            $table->boolean('bedroom_clean_condition')->nullable(); // Kolom boolean
            $table->boolean('bedroom_lighting')->nullable(); // Kolom boolean
            $table->boolean('bedroom_area_minimum')->nullable(); // Kolom boolean
            $table->boolean('ceiling_height_minimum')->nullable(); // Kolom boolean
            $table->boolean('general_room_no_hazardous_materials')->nullable(); // Kolom boolean
            $table->boolean('general_room_safe_easily_cleaned')->nullable(); // Kolom boolean

             // Lantai Rumah
             $table->boolean('floor_waterproof')->nullable(); // Lantai bangunan kedap air
             $table->boolean('floor_smooth_no_cracks')->nullable(); // Permukaan rata, halus, tidak licin, dan tidak retak
             $table->boolean('floor_dust_resistant')->nullable(); // Lantai tidak menyerap debu dan mudah dibersihkan
             $table->boolean('floor_sloped_for_cleaning')->nullable(); // Lantai yang kontak dengan air dan memiliki kemiringan cukup landai
             $table->boolean('floor_clean')->nullable(); // Lantai rumah dalam keadaan bersih
             $table->boolean('floor_light_color')->nullable(); // Warna lantai harus berwarna terang

             // Ventilasi Rumah
             $table->boolean('ventilation_present')->nullable(); // Ada ventilasi rumah
             $table->boolean('ventilation_area')->nullable(); // Luas ventilasi permanen > 10% luas lantai

             // Pencahayaan Rumah
             $table->boolean('lighting_present')->nullable(); // Ada pencahayaan rumah
             $table->boolean('lighting_brightness')->nullable(); // Terang, tidak silau sehingga dapat untuk baca dengan normal

             // Ketersediaan Air
             $table->boolean('safe_drinking_water_source')->nullable();
             $table->boolean('drinking_water_location')->nullable();
             $table->boolean('water_supply_hrs')->nullable();
             $table->boolean('water_quality')->nullable();

             // Toilet/Sanitasi
             $table->boolean('toilet_usage')->nullable();
             $table->boolean('own_toilet')->nullable();
             $table->boolean('squat_toilet')->nullable();
             $table->boolean('septic_tank')->nullable();

             // Sarana CTPS
             $table->boolean('ctps_facility')->nullable();
             $table->boolean('ctps_accessibility')->nullable();

             // Tempat Pengelolaan Sampah Rumah Tangga
             $table->boolean('trash_bin_available')->nullable();
             $table->boolean('trash_disposal')->nullable();
             $table->boolean('trash_segregation')->nullable();

             // Tempat Pengelolaan Limbah Cair Rumah Tangga
             $table->boolean('no_water_puddles')->nullable();
             $table->boolean('connection_to_sewerage')->nullable();
             $table->boolean('closed_waste_management')->nullable();

             // Kandang Ternak
             $table->boolean('separated_cattle_shed')->nullable();

             // Perilaku
             $table->boolean('bedroom_window_open')->nullable();
             $table->boolean('living_room_window_open')->nullable();
             $table->boolean('ventilation_open')->nullable();
             $table->boolean('ctps_practice')->nullable();
             $table->boolean('psn_practice')->nullable();

             // Hasil Sanitarian Kit - Parameter Ruang
             $table->boolean('room_noise_level')->nullable();
             $table->boolean('room_humidity')->nullable();
             $table->boolean('room_brightness')->nullable();
             $table->boolean('room_air_ventilation')->nullable();
             $table->boolean('room_temperature')->nullable();

             // Hasil Sanitarian Kit - Parameter Air
             $table->boolean('water_ph')->nullable();
             $table->boolean('water_temperature')->nullable();
             $table->boolean('water_tds')->nullable();

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
