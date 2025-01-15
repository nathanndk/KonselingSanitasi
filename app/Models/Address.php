<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'address';

    protected $fillable = [
        'street', 'district_code', 'subdistrict_code', 'rt', 'rw'
    ];

    public function healthCenters()
    {
        return $this->hasMany(HealthCenter::class);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_code', 'district_code');
    }

    public function subdistrict()
    {
        return $this->belongsTo(Subdistrict::class, 'subdistrict_code', 'subdistrict_code');
    }
}
