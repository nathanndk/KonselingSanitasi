<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdamParameterCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'created_by', 'updated_by', 'value'
    ];

    public function parameters()
    {
        return $this->hasMany(PdamParameter::class, 'parameter_category_id');
    }

    public function values()
    {
        return $this->hasMany(PdamParameterValue::class, 'parameter_category_id');
    }

    public function conditions()
    {
        return $this->hasMany(PdamCondition::class, 'pdam_condition_id');
    }
}
