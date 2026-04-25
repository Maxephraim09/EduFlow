<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'school_id', 'username', 'email', 'password', 'phone',
        'alternative_phone', 'address', 'profile_photo', 'language',
        'theme', 'status', 'last_login_at', 'last_login_ip',
        'email_verified_at', 'remember_token'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function isAdmin()
    {
        return $this->username === 'superadmin' || $this->email === 'admin@school.com';
    }

    public function isTeacher()
    {
        return $this->teacher !== null;
    }

    public function isStudent()
    {
        return $this->student !== null;
    }
}