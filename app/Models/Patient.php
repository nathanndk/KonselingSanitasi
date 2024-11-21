<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'name',
        'date_of_birth',
        'gender',
        'phone_number',
        'address_id',
        'created_by',
        'updated_by',
        'event_id',
        'sanitation_condition_id',
        'district_code',
        'subdistrict_code',
        'health_center_id'
    ];

    public static function booted()
    {
        static::creating(function ($patient) {
            // Jika NIK kosong, buat NIK otomatis
            if (empty($patient->nik)) {
                // Ambil NIK terakhir dan increment
                $lastNIK = self::orderByDesc('nik')->first()->nik ?? 'NON0000000000000';
                $newNIK = 'NON' . str_pad((intval(substr($lastNIK, 3)) + 1), 13, '0', STR_PAD_LEFT);
                $patient->nik = $newNIK;  // Set NIK baru
            }
        });
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function sanitationCondition()
    {
        return $this->belongsTo(SanitationCondition::class, 'sanitation_condition_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_code');
    }

    public function subdistrict()
    {
        return $this->belongsTo(Subdistrict::class, 'subdistrict_code');
    }

    public function event()
    {
        return $this->belongsTo(HealthEvent::class, 'event_id');
    }

    public function healthCenter()
    {
        return $this->belongsTo(HealthCenter::class, 'health_center_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
