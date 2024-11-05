<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdamParameterCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'created_by', 'updated_by'
    ];

    public function parameters()
    {
        return $this->hasMany(PDAMParameter::class, 'parameter_category_id');
    }

    public function condition()
    {
        return $this->belongsTo(PDAMCondition::class, 'condition_id');
    }

    public function values()
    {
        return $this->hasMany(PdamParameterValue::class, 'category_id');
    }
}
