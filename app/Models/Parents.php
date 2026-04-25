<?php
// app/Models/Parents.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Parents extends Model
{
    use HasFactory;

    protected $table = 'parents';

    protected $fillable = [
        'user_id', 'school_id', 'first_name', 'last_name', 'occupation',
        'relationship', 'phone', 'alternative_phone', 'email', 'address', 'id_card_number'
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

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'student_parents', 'parent_id', 'student_id')
                    ->withPivot('is_primary_contact', 'can_receive_sms', 'can_receive_email', 'can_receive_push')
                    ->withTimestamps();
    }

    // Accessors
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}