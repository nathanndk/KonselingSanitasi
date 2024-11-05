<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PdamParameter extends Model
{
    protected $fillable = ['name', 'parameter_category_id', 'condition_id', 'created_by', 'updated_by'];

    public function category()
    {
        return $this->belongsTo(PDAMParameterCategory::class, 'parameter_category_id');
    }


    public function condition()
    {
        return $this->belongsTo(PDAMCondition::class, 'condition_id');
    }

    public function values()
    {
        return $this->hasMany(PDAMParameterValue::class, 'parameter_id');
    }
}
