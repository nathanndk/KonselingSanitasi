<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanitationCondition extends Model
{
    use HasFactory;

    protected $fillable = [
        'counseling_date',
        'patient_id',
        'condition',
        'recommendation',
        'home_visit_date',
        'intervention',
        'notes',
        'created_by',
        'updated_by'
    ];


    public function counselingReports()
    {
        return $this->hasMany(CounselingReport::class);
    }

    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class);
    }

    public function event()
    {
        return $this->belongsTo(HealthEvent::class, 'event_id');
    }

}
