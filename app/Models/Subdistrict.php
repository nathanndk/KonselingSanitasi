<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subdistrict extends Model
{
    use HasFactory;

    protected $table = 'subdistrict';

    protected $fillable = [
        'subdistrict_name',
        'subdistrict_code',
        'district_code',
    ];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_code', 'district_code');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'subdistrict_id');
    }
}
