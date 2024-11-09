<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'start_time', 'end_time', 'created_by', 'updated_by', 'event_date'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function statuses()
    {
        return $this->hasMany(EventStatus::class, 'event_id');
    }

    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'event_id');
    }

    public function pdamConditions()
    {
        return $this->hasMany(PdamCondition::class, 'event_id');
    }

    public function sanitationConditions()
    {
        return $this->hasMany(SanitationCondition::class, 'event_id');
    }

    public function counselingReports()
    {
        return $this->hasMany(SanitationCondition::class, 'event_id');
    }

    public function houseConditions()
    {
        return $this->hasMany(HouseCondition::class, 'event_id');
    }

}
