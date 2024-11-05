<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseCondition extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'created_by',
        'updated_by'
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function parameters()
    {
        return $this->hasMany(HouseParameter::class);
    }

    public function category()
    {
        return $this->belongsTo(HouseParameterCategory::class);
    }
}
