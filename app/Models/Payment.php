<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    
    protected $table = 'payments';
    protected $primaryKey = 'id';
    protected $fillable = ['enrollment_id', 'payment_date', 'amount'];
    
    /**
     * Get the enrollment that owns the payment.
     */
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
    
    /**
     * Get the student associated with this payment through enrollment.
     */
    public function student()
    {
        return $this->hasOneThrough(Student::class, Enrollment::class, 'id', 'id', 'enrollment_id', 'student_id');
    }
}
