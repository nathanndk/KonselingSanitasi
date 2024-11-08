<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdamParameterValue extends Model
{
    use HasFactory;

    protected $fillable = ['parameter_id', 'value', 'pdam_condition_id', 'created_by'];

    public function parameters()
    {
        return $this->belongsTo(PdamParameter::class, 'parameter_id');
    }

    public function conditions()
    {
        return $this->belongsTo(PdamCondition::class, 'pdam_condition_id');
    }

    public function categories()
    {
        return $this->belongsTo(PdamParameterCategory::class, 'parameter_category_id');
    }
}
