<?php
// app/Models/FeePayment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeePayment extends Model
{
    use HasFactory;

    protected $table = 'fee_payments';

    protected $fillable = [
        'school_id', 'student_id', 'invoice_number', 'receipt_number',
        'amount', 'payment_date', 'payment_method', 'transaction_id',
        'bank_name', 'cheque_number', 'payment_status', 'payment_proof',
        'notes', 'recorded_by', 'approved_by', 'approved_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
        'approved_at' => 'datetime',
    ];

    // Relationships
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}