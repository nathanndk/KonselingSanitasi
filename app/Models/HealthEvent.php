<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'start_time', 'end_time', 'created_by', 'updated_by', 'event_date','health_center_id'
    ];

    public function patient()
    {
        return $this->belongsToMany(Patient::class, 'event_id');
    }

    public function sanitationConditions()
    {
        return $this->hasMany(SanitationCondition::class, 'event_id');
    }

    public function counselingReports()
    {
        return $this->hasMany(SanitationCondition::class, 'event_id');
    }

    public function Pdam(){
        return $this->hasMany(PDAM::class, 'event_id');
    }

    public function HousingSurvey(){
        return $this->hasMany(HousingSurvey::class, 'event_id');

    }
    public function user(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function healthCenter(){
        return $this->belongsTo(HealthCenter::class, 'health_center_id');
    }

}
