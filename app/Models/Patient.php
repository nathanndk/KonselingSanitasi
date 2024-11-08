<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik', 'name', 'date_of_birth', 'gender', 'phone_number', 'address_id', 'created_by', 'updated_by'
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
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
        return $this->belongsTo(SanitationCondition::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function subdistrict()
    {
        return $this->belongsTo(Subdistrict::class);
    }
}
