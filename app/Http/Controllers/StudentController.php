<?php
// app/Http/Controllers/StudentController.php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Classes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('currentClass')->paginate(10);
        return view('students.index', compact('students'));
    }

    public function create()
    {
        $classes = Classes::where('status', 'active')->get();
        return view('students.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'admission_number' => 'required|unique:students',
            'current_class_id' => 'nullable|exists:classes,id',
            'date_of_birth' => 'nullable|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'nullable|string',
        ]);

        // Create user account
        $user = User::create([
            'username' => Str::slug($request->first_name . '.' . $request->last_name),
            'email' => $request->email,
            'password' => Hash::make('password123'),
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => 'active',
        ]);

        // Create student profile
        $student = Student::create([
            'user_id' => $user->id,
            'school_id' => 1, // Default school
            'admission_number' => $request->admission_number,
            'admission_date' => now(),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
            'current_class_id' => $request->current_class_id,
            'status' => 'active',
        ]);

        return redirect()->route('students.index')
            ->with('success', 'Student created successfully! Password: password123');
    }

    public function show(Student $student)
    {
        $student->load('currentClass', 'user');
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $classes = Classes::where('status', 'active')->get();
        return view('students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'current_class_id' => 'nullable|exists:classes,id',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
        ]);

        $student->update($request->only([
            'first_name', 'last_name', 'date_of_birth', 
            'address', 'current_class_id'
        ]));

        // Update user info
        $student->user->update([
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('students.show', $student)
            ->with('success', 'Student updated successfully!');
    }

    public function destroy(Student $student)
    {
        $user = $student->user;
        $student->delete();
        $user->delete();

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully!');
    }
}