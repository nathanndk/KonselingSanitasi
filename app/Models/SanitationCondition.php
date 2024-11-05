<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanitationCondition extends Model
{
    use HasFactory;

    protected $fillable = [
        'description', 'created_by', 'updated_by'
    ];

    public function counselingReports()
    {
        return $this->hasMany(CounselingReport::class);
    }

    public function patient()
{
    return $this->belongsTo(\App\Models\Patient::class);
}

}
