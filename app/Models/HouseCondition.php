<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseCondition extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'parameter_category_id',
        'created_by',
        'updated_by'
    ];

    public function parameters()
    {
        return $this->hasMany(HouseParameter::class, 'house_condition_id');
    }

    public function categories()
    {
        return $this->belongsTo(HouseParameterCategory::class, 'parameter_category_id');
    }

    public function values()
    {
        return $this->hasMany(HouseParameterValue::class, 'house_condition_id');
    }
}
