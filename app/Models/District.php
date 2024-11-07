<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $table = 'district';

    protected $fillable = [
        'district_code',
        'district_name',
    ];

    public function subdistricts()
    {
        return $this->hasMany(Subdistrict::class, 'district_code', 'district_code');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'district_id');
    }
}
