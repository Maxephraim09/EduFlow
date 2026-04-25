<?php
// app/Models/School.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'address', 'phone', 'email', 'logo', 'website',
        'motto', 'established_year', 'slogan', 'currency', 'timezone',
        'academic_term', 'status', 'settings'
    ];

    protected $casts = [
        'settings' => 'array',
        'established_year' => 'integer',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function classes()
    {
        return $this->hasMany(Classes::class);
    }
}