<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseParameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'parameter_category_id', 'name', 'created_by', 'updated_by'
    ];

    public function category()
    {
        return $this->belongsTo(HouseParameterCategory::class, 'parameter_category_id');
    }

    public function parameters()
    {
        return $this->hasMany(HouseParameterValue::class);
    }

    public function condition()
    {
        return $this->hasMany(HouseCondition::class);
    }

    public function values()
    {
        return $this->hasMany(HouseParameterValue::class, 'parameter_id');
    }
}
