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
        'safe_drinking_water_source',
        'drinking_water_location',
        'toilet_usage',
        'own_toilet',
        'ctps_facility',
        'ctps_accessibility',
        'bedroom_window_open',
        'living_room_window_open',
        'noise_level',
        'humidity',
        'score',
        'houseworthiness_score',
        'houseworthiness_status',
        'sanitation_score',
        'sanitation_status',
        'behavior_score',
        'behavior_status',
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
        'safe_drinking_water_source' => 'boolean',
        'drinking_water_location' => 'boolean',
        'toilet_usage' => 'boolean',
        'own_toilet' => 'boolean',
        'ctps_facility' => 'boolean',
        'ctps_accessibility' => 'boolean',
        'bedroom_window_open' => 'boolean',
        'living_room_window_open' => 'boolean',
        'noise_level' => 'boolean',
        'humidity' => 'boolean',
        'score' => 'integer',
        'houseworthiness_score' => 'decimal:2',
        'houseworthiness_status' => 'string',
        'sanitation_score' => 'decimal:2',
        'sanitation_status' => 'string',
        'behavior_score' => 'decimal:2',
        'behavior_status' => 'string',
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

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
