<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounselingReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id', 'counseling_date', 'address_id', 'sanitation_condition_id', 'recommendation',
        'house_visit_date', 'intervention', 'notes', 'created_by', 'updated_by'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function sanitationCondition()
    {
        return $this->belongsTo(SanitationCondition::class);
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
