<?php
// app/Models/Classes.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classes extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'school_id', 'name', 'code', 'grade_level', 'capacity', 
        'class_teacher_id', 'classroom', 'status', 'sort_order'
    ];

    protected $casts = [
        'capacity' => 'integer',
        'grade_level' => 'integer',
        'sort_order' => 'integer',
    ];

    // Relationships
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function classTeacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'class_teacher_id');
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'current_class_id');
    }

    public function subjects(): HasMany
    {
        return $this->hasMany(ClassSubject::class);
    }

    // Accessors
    public function getStudentCountAttribute(): int
    {
        return $this->students()->count();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}