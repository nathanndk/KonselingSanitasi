<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PdamParameterValue extends Model
{
    protected $fillable = ['parameter_id', 'value', 'pdam_condition_id', 'created_by'];


    public function parameter()
    {
        return $this->belongsTo(PDAMParameter::class, 'parameter_id');
    }

    public function condition()
    {
        return $this->belongsTo(PDAMCondition::class, 'condition_id');
    }

    public function category()
    {
        return $this->belongsTo(PDAMParameterCategory::class, 'category_id');
    }
}
