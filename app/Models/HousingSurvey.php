<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\WaterSource;
use App\Enums\EducationLevel;
use App\Enums\JobType;
use App\Enums\HouseOwnership;

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
        'roof_quality',
        'ceiling_quality',
        'wall_quality',
        'bedroom_condition',
        'public_room_condition',
        'floor_condition',
        'ventilation',
        'lighting',
        'drinking_water_available',
        'toilet_available',
        'ctps_facility',
        'trash_management',
        'liquid_waste_management',
        'livestock_pen_separate',
        'noise_level',
        'humidity',
        'illumination',
        'ventilation_rate',
        'room_temperature',
        'water_ph',
        'water_temperature',
        'water_tds',
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
        'updated_by',
    ];

    protected $casts = [
        'drinking_water_source' => WaterSource::class,
        'clean_water_source' => WaterSource::class,
        'last_education' => EducationLevel::class,
        'job' => JobType::class,
        'house_ownership' => HouseOwnership::class,
        'landslide_prone' => 'boolean',
        'garbage_site_nearby' => 'boolean',
        'high_voltage_area' => 'boolean',
        'roof_quality' => 'boolean',
        'ceiling_quality' => 'boolean',
        'wall_quality' => 'boolean',
        'bedroom_condition' => 'boolean',
        'public_room_condition' => 'boolean',
        'floor_condition' => 'boolean',
        'ventilation' => 'boolean',
        'lighting' => 'boolean',
        'drinking_water_available' => 'boolean',
        'toilet_available' => 'boolean',
        'ctps_facility' => 'boolean',
        'trash_management' => 'boolean',
        'liquid_waste_management' => 'boolean',
        'livestock_pen_separate' => 'boolean',
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
