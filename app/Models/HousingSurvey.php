<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HousingSurvey extends Model
{
    use HasFactory;

    protected $table = 'housing_surveys';

    protected $fillable = [
        'sampling_date',
        'diagnosed_disease',
        'head_of_family',
        'drinking_water_source',
        'clean_water_source',
        'last_education',
        'job',
        'family_members',
        'house_ownership',
        'house_area',
        'landslide_prone',
        'garbage_site_nearby',
        'high_voltage_area',
        'roof_strong_no_leak',
        'roof_drainage',
        'ceiling_strong_safe',
        'ceiling_clean_no_dust',
        'ceiling_flat_adequate_air',
        'ceiling_clean_condition',
        'wall_strong_waterproof',
        'wall_smooth_no_cracks',
        'wall_no_dust_easy_clean',
        'wall_bright_color',
        'wall_clean_condition',
        'bedroom_clean_condition',
        'bedroom_lighting',
        'bedroom_area_minimum',
        'ceiling_height_minimum',
        'general_room_no_hazardous_materials',
        'general_room_safe_easily_cleaned',
        'floor_waterproof',
        'floor_smooth_no_cracks',
        'floor_dust_resistant',
        'floor_sloped_for_cleaning',
        'floor_clean',
        'floor_light_color',
        'ventilation_present',
        'ventilation_area',
        'lighting_present',
        'lighting_brightness',
        'safe_drinking_water_source',
        'drinking_water_location',
        'water_supply_hrs',
        'water_quality',
        'toilet_usage',
        'own_toilet',
        'squat_toilet',
        'septic_tank',
        'sewage_system',
        'ctps_facility',
        'ctps_accessibility',
        'trash_bin_available',
        'trash_disposal',
        'trash_segregation',
        'no_water_puddles',
        'connection_to_sewerage',
        'closed_waste_management',
        'separated_cattle_shed',
        'bedroom_window_open',
        'living_room_window_open',
        'ventilation_open',
        'ctps_practice',
        'psn_practice',
        'room_noise_level',
        'room_humidity',
        'room_brightness',
        'room_air_ventilation',
        'room_temperature',
        'water_ph',
        'water_temperature',
        'water_tds',
        'notes',
        'patient_id',
        'event_id',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'sampling_date' => 'date',
        'drinking_water_source' => 'string',
        'clean_water_source' => 'string',
        'last_education' => 'string',
        'job' => 'string',
        'house_ownership' => 'string',
        'house_area' => 'string',
        'landslide_prone' => 'boolean',
        'garbage_site_nearby' => 'boolean',
        'high_voltage_area' => 'boolean',
        'roof_strong_no_leak' => 'boolean',
        'roof_drainage' => 'boolean',
        'ceiling_strong_safe' => 'boolean',
        'ceiling_clean_no_dust' => 'boolean',
        'ceiling_flat_adequate_air' => 'boolean',
        'ceiling_clean_condition' => 'boolean',
        'wall_strong_waterproof' => 'boolean',
        'wall_smooth_no_cracks' => 'boolean',
        'wall_no_dust_easy_clean' => 'boolean',
        'wall_bright_color' => 'boolean',
        'wall_clean_condition' => 'boolean',
        'bedroom_clean_condition' => 'boolean',
        'bedroom_lighting' => 'boolean',
        'bedroom_area_minimum' => 'boolean',
        'ceiling_height_minimum' => 'boolean',
        'general_room_no_hazardous_materials' => 'boolean',
        'general_room_safe_easily_cleaned' => 'boolean',
        'floor_waterproof' => 'boolean',
        'floor_smooth_no_cracks' => 'boolean',
        'floor_dust_resistant' => 'boolean',
        'floor_sloped_for_cleaning' => 'boolean',
        'floor_clean' => 'boolean',
        'floor_light_color' => 'boolean',
        'ventilation_present' => 'boolean',
        'ventilation_area' => 'boolean',
        'lighting_present' => 'boolean',
        'lighting_brightness' => 'boolean',
        'safe_drinking_water_source' => 'boolean',
        'drinking_water_location' => 'boolean',
        'water_supply_24hrs' => 'boolean',
        'water_quality' => 'boolean',
        'toilet_usage' => 'boolean',
        'own_toilet' => 'boolean',
        'squat_toilet' => 'boolean',
        'septic_tank' => 'boolean',
        'sewage_system' => 'boolean',
        'ctps_facility' => 'boolean',
        'ctps_accessibility' => 'boolean',
        'trash_bin_available' => 'boolean',
        'trash_disposal' => 'boolean',
        'trash_segregation' => 'boolean',
        'no_water_puddles' => 'boolean',
        'connection_to_sewerage' => 'boolean',
        'closed_waste_management' => 'boolean',
        'separated_cattle_shed' => 'boolean',
        'bedroom_window_open' => 'boolean',
        'living_room_window_open' => 'boolean',
        'ventilation_open' => 'boolean',
        'ctps_practice' => 'boolean',
        'psn_practice' => 'boolean',
        'room_noise_level' => 'boolean',
        'room_humidity' => 'boolean',
        'room_brightness' => 'boolean',
        'room_air_ventilation' => 'boolean',
        'room_temperature' => 'boolean',
        'water_ph' => 'boolean',
        'water_temperature' => 'boolean',
        'water_tds' => 'boolean',
        'notes' => 'string',
        'patient_id' => 'integer',
        'event_id' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function event()
    {
        return $this->belongsTo(HealthEvent::class, 'event_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
