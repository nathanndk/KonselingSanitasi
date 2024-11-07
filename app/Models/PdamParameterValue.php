<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdamParameterValue extends Model
{
    use HasFactory;

    protected $fillable = ['parameter_id', 'value', 'pdam_condition_id', 'created_by'];

    /**
     * Relationship to PDAMParameter model.
     * Each value belongs to one parameter.
     */
    public function parameter()
    {
        return $this->belongsTo(PdamParameter::class, 'parameter_id');
    }

    /**
     * Relationship to PDAMCondition model.
     * Each value is associated with one condition.
     */
    public function condition()
    {
        return $this->belongsTo(PdamCondition::class, 'pdam_condition_id');
    }

    /**
     * Relationship to PDAMParameterCategory model.
     * Each value can belong to one category if applicable.
     */
    public function category()
    {
        return $this->belongsTo(PdamParameterCategory::class, 'parameter_category_id');
    }
}
