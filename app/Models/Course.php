<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Course extends Model
{
    use HasFactory;
    
    protected $table = 'courses';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'syllabus', 'duration'];

    public function duration()
    {
        return $this->duration.  " Months " ;
    }
    
    /**
     * Lấy các giáo viên dạy khóa học này
     */
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_course')
                    ->withPivot('role', 'is_primary')
                    ->withTimestamps();
    }
    
    /**
     * Lấy giáo viên chính của khóa học
     */
    public function primaryTeacher()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_course')
                    ->wherePivot('is_primary', true)
                    ->withPivot('role')
                    ->withTimestamps();
    }
    
    /**
     * Lấy các lớp học thuộc khóa học này
     */
    public function batches()
    {
        return $this->hasMany(Batch::class);
    }
    
    /**
     * Lấy tất cả sinh viên đăng ký khóa học này thông qua các lớp học
     */
    public function students()
    {
        return $this->hasManyThrough(
            Student::class,
            Enrollment::class,
            'batch_id', // Khóa ngoại trên enrollments
            'id', // Khóa chính trên students
            'id', // Khóa chính trên courses
            'student_id' // Khóa ngoại trên enrollments
        );
    }
}
