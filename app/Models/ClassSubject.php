<?php
// app/Models/ClassSubject.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassSubject extends Model
{
    use HasFactory;

    protected $table = 'class_subjects';

    protected $fillable = [
        'class_id', 'subject_id', 'teacher_id', 'is_compulsory', 'total_periods'
    ];

    protected $casts = [
        'is_compulsory' => 'boolean',
        'total_periods' => 'integer',
    ];

    // Relationships
    public function class(): BelongsTo
    {
        return $this->belongsTo(Classes::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }
}