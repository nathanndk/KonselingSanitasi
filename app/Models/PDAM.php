<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\TingkatResiko;

class PDAM extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pdam';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sampling_date',
        'risk_level',
        'remaining_chlorine',
        'ph',
        'tds_measurement',
        'temperature_measurement',
        'total_coliform',
        'e_coli',
        'tds_lab',
        'turbidity',
        'color',
        'odor',
        'temperature_lab',
        'aluminium',
        'arsenic',
        'cadmium',
        'remaining_chlorine_lab',
        'chromium_val_6',
        'fluoride',
        'iron',
        'lead',
        'manganese',
        'nitrite',
        'nitrate',
        'ph_lab',
        'notes',
        'patient_id',
        'event_id',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'risk_level' => TingkatResiko::class,
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function events()
    {
        return $this->belongsTo(HealthEvent::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
