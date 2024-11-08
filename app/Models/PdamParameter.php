<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdamParameter extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parameter_category_id', 'value', 'condition_id', 'created_by', 'updated_by'];

    public function categories()
    {
        return $this->belongsTo(PdamParameterCategory::class, 'parameter_category_id');
    }

    public function conditions()
    {
        return $this->belongsTo(PdamCondition::class, 'condition_id');
    }

    public function values()
    {
        return $this->hasMany(PdamParameterValue::class, 'parameter_id');
    }
}
