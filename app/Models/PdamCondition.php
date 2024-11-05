<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PdamCondition extends Model
{
    // Tambahkan kolom 'updated_by' jika memang ada dalam tabel dan perlu diisi
    protected $fillable = ['description', 'created_by', 'updated_by'];

    /**
     * Relationship to PDAMParameter model.
     */
    public function parameters()
    {
        return $this->hasMany(PDAMParameter::class, 'condition_id');
    }

    /**
     * Relationship to PDAMParameterCategory model.
     * Pastikan ini sesuai dengan relasi di database jika ada kategori.
     */
    public function category()
    {
        return $this->belongsTo(PDAMParameterCategory::class, 'parameter_category_id');
    }

    /**
     * Boot method to handle created_by and updated_by fields automatically.
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
