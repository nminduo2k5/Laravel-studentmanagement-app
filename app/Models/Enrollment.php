<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enrollment extends Model
{
    use HasFactory;

    protected $table = 'enrollments';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'enroll_no',
        'batch_id',
        'student_id',
        'join_date',
        'fees',
        'midterm_grade',
        'final_grade',
        'assignment_grade',
        'total_grade',
        'grade_remarks'
    ];
    
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
    
    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }
    
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
    
    public function getGradeStatus(): string
    {
        if (isset($this->total_grade)) {
            if ($this->total_grade >= 8.5) return 'Xuất sắc';
            if ($this->total_grade >= 7.0) return 'Giỏi';
            if ($this->total_grade >= 5.5) return 'Khá';
            if ($this->total_grade >= 4.0) return 'Trung bình';
            return 'Không đạt';
        }
        return 'Chưa có điểm';
    }
}