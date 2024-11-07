<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PdamCondition extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'created_by', 'updated_by'];

    /**
     * Relationship to PDAMParameter model.
     * Each condition can have multiple parameters.
     */
    public function parameters()
    {
        return $this->hasMany(PdamParameter::class, 'condition_id');
    }

    /**
     * Automatically set created_by and updated_by fields.
     */
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
