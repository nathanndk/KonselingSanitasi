<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecursiveCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'parent_id', 'created_by', 'updated_by'
    ];

    public function parent()
    {
        return $this->belongsTo(RecursiveCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(RecursiveCategory::class, 'parent_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
