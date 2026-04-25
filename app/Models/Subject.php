<?php
// app/Models/Subject.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects';

    protected $fillable = [
        'school_id', 'name', 'code', 'category', 'subject_type',
        'credit_hours', 'passing_marks', 'maximum_marks', 'minimum_marks',
        'icon', 'color', 'sort_order', 'status'
    ];

    protected $casts = [
        'credit_hours' => 'integer',
        'passing_marks' => 'decimal:2',
        'maximum_marks' => 'decimal:2',
        'minimum_marks' => 'decimal:2',
        'sort_order' => 'integer',
    ];

    // Relationships
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function classSubjects(): HasMany
    {
        return $this->hasMany(ClassSubject::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCore($query)
    {
        return $query->where('category', 'core');
    }
}