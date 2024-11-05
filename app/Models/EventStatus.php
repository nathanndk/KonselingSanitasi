<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 'status'
    ];

    public function event()
    {
        return $this->belongsTo(HealthEvent::class);
    }
}
