<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseParameterCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'created_by', 'updated_by'
    ];

    public function parameters()
    {
        return $this->hasMany(HouseParameter::class, 'parameter_id');
    }

    public function conditions()
    {
        return $this->hasMany(HouseCondition::class, 'house_condition_id');
    }

    public function values()
    {
        return $this->hasMany(HouseParameterValue::class, 'parameter_category_id');
    }
}
