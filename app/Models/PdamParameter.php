<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdamParameter extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parameter_category_id', 'condition_id', 'created_by', 'updated_by'];

    /**
     * Relationship to PDAMParameterCategory model.
     * Each parameter belongs to one category.
     */
    public function category()
    {
        return $this->belongsTo(PdamParameterCategory::class, 'parameter_category_id');
    }

    /**
     * Relationship to PDAMCondition model.
     * Each parameter belongs to one condition.
     */
    public function condition()
    {
        return $this->belongsTo(PdamCondition::class, 'condition_id');
    }

    /**
     * Relationship to PDAMParameterValue model.
     * Each parameter can have multiple values.
     */
    public function values()
    {
        return $this->hasMany(PdamParameterValue::class, 'parameter_id');
    }
}
