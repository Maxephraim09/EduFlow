<?php
// app/Models/Teacher.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'teachers';

    protected $fillable = [
        'user_id', 'school_id', 'staff_id', 'first_name', 'last_name',
        'qualification', 'specialization', 'joining_date', 'employment_type',
        'subjects_taught', 'salary_grade', 'bank_name', 'account_number',
        'account_name', 'nok_name', 'nok_phone', 'nok_relationship',
        'cv_document', 'certificates', 'status'
    ];

    protected $casts = [
        'subjects_taught' => 'array',
        'certificates' => 'array',
        'joining_date' => 'date',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function classes(): HasMany
    {
        return $this->hasMany(Classes::class, 'class_teacher_id');
    }

    // Accessors
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}