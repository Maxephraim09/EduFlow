<?php
// app/Models/Student.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'user_id', 'school_id', 'admission_number', 'admission_date',
        'first_name', 'last_name', 'middle_name', 'date_of_birth',
        'gender', 'blood_group', 'religion', 'nationality', 'state_of_origin',
        'lga', 'address', 'emergency_contact_name', 'emergency_contact_phone',
        'emergency_contact_relationship', 'medical_conditions', 'allergies',
        'disabilities', 'current_class_id', 'current_section_id', 'status', 'profile_photo'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'admission_date' => 'date',
        'medical_conditions' => 'array',
        'allergies' => 'array',
        'disabilities' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function currentClass(): BelongsTo
    {
        return $this->belongsTo(Classes::class, 'current_class_id');
    }

    public function currentSection(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'current_section_id');
    }

    public function parents(): BelongsToMany
    {
        return $this->belongsToMany(Parents::class, 'student_parents', 'student_id', 'parent_id')
                    ->withPivot('is_primary_contact', 'can_receive_sms', 'can_receive_email', 'can_receive_push')
                    ->withTimestamps();
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(StudentAttendance::class);
    }

    public function feePayments(): HasMany
    {
        return $this->hasMany(FeePayment::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth?->age;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByClass($query, $classId)
    {
        return $query->where('current_class_id', $classId);
    }
}