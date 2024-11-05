<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'address';

    protected $fillable = [
        'street', 'subdistrict', 'district', 'city', 'province'
    ];

    public function healthCenters()
    {
        return $this->hasMany(HealthCenter::class);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    public function counselingReports()
    {
        return $this->hasMany(CounselingReport::class);
    }
}
