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
                $patient->nik = self::generateNik();
            }
        });
    }

    private static function generateNik()
    {
        // Hitung jumlah pasien dengan NIK yang dimulai dengan 'NON'
        $nonPatientCount = self::where('nik', 'like', 'NON%')->count();

        // Increment dari jumlah pasien dengan prefix 'NON'
        $newNumber = $nonPatientCount + 1;

        // Format menjadi NON + angka 13 digit
        return 'NON' . str_pad($newNumber, 13, '0', STR_PAD_LEFT);
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
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
