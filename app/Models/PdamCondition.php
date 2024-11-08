<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PdamCondition extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'created_by', 'updated_by', 'value'];

    public function parameters()
    {
        return $this->hasMany(PdamParameter::class, 'condition_id');
    }

    public function values()
    {
        return $this->hasMany(PdamParameterValue::class, 'pdam_condition_id');
    }

    public function categories()
    {
        return $this->hasMany(PdamParameterCategory::class, 'pdam_condition_id');
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->created_by = Auth::id();
            $model->updated_by = Auth::id();
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    }
}
