<?php
// app/Models/Event.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'school_id', 'title', 'description', 'event_type', 'start_datetime',
        'end_datetime', 'venue', 'venue_map_link', 'budget', 'organizer_name',
        'organizer_phone', 'organizer_email', 'color', 'is_public', 'status', 'created_by'
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'budget' => 'decimal:2',
        'is_public' => 'boolean',
    ];

    // Relationships
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function participants(): HasMany
    {
        return $this->hasMany(EventParticipant::class);
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('start_datetime', '>=', now())
                     ->where('status', 'scheduled')
                     ->orderBy('start_datetime', 'asc');
    }

    public function scopeOngoing($query)
    {
        return $query->where('start_datetime', '<=', now())
                     ->where('end_datetime', '>=', now())
                     ->where('status', 'ongoing');
    }
}