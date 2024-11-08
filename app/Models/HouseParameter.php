<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseParameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'parameter_category_id', 'name', 'created_by', 'updated_by', 'value', 'house_condition_id'
    ];

    public function categories()
    {
        return $this->belongsTo(HouseParameterCategory::class, 'parameter_category_id');
    }

    public function conditions()
    {
        return $this->hasMany(HouseCondition::class,'house_condition_id');
    }

    public function values()
    {
        return $this->hasMany(HouseParameterValue::class, 'parameter_id');
    }

}
