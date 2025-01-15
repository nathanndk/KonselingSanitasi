<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanitationCondition extends Model
{
    use HasFactory;

    protected $fillable = [
        'sampling_date',
        'patient_id',
        'condition',
        'recommendation',
        'home_visit_date',
        'intervention',
        'notes',
        'created_by',
        'updated_by'
    ];



    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class);
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
