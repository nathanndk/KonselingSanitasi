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

    /**
     * Relationship to PDAMParameter model.
     * Each category can have multiple parameters.
     */
    public function parameters()
    {
        return $this->hasMany(PdamParameter::class, 'parameter_category_id');
    }
}
