<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseParameterValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'parameter_id', 'house_condition_id', 'value', 'created_by', 'updated_by'
    ];

    public function parameters()
    {
        return $this->belongsTo(HouseParameter::class);
    }

    public function conditions()
    {
        return $this->belongsTo(HouseCondition::class);
    }
}
