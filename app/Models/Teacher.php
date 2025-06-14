<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory;
    
    protected $table = 'teachers';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'address', 'mobile', 'email', 'specialization', 'experience', 'qualification', 'join_date'];
    
    /**
     * Lấy các khóa học mà giáo viên dạy
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'teacher_course')
                    ->withPivot('role', 'is_primary')
                    ->withTimestamps();
    }
    
    /**
     * Lấy các khóa học mà giáo viên là giáo viên chính
     */
    public function primaryCourses()
    {
        return $this->belongsToMany(Course::class, 'teacher_course')
                    ->wherePivot('is_primary', true)
                    ->withPivot('role')
                    ->withTimestamps();
    }
    
    /**
     * Lấy các batch (lớp học) mà giáo viên dạy thông qua khóa học
     */
    public function getBatchesAttribute()
    {
        $courseIds = $this->courses()->pluck('courses.id')->toArray();
        return Batch::whereIn('course_id', $courseIds)->get();
    }
    
    /**
     * Đếm số lượng batch (lớp học) mà giáo viên dạy
     */
    public function getBatchesCountAttribute()
    {
        $courseIds = $this->courses()->pluck('courses.id')->toArray();
        return Batch::whereIn('course_id', $courseIds)->count();
    }
    
    /**
     * Lấy số lượng sinh viên mà giáo viên dạy
     */
    public function getStudentsAttribute()
    {
        $courseIds = $this->courses()->pluck('courses.id')->toArray();
        $batchIds = Batch::whereIn('course_id', $courseIds)->pluck('id')->toArray();
        
        return Student::whereHas('enrollments', function($query) use ($batchIds) {
            $query->whereIn('batch_id', $batchIds);
        })->get();
    }
    
    /**
     * Đếm số lượng sinh viên mà giáo viên dạy
     */
    public function getStudentsCountAttribute()
    {
        $courseIds = $this->courses()->pluck('courses.id')->toArray();
        $batchIds = Batch::whereIn('course_id', $courseIds)->pluck('id')->toArray();
        
        return Student::whereHas('enrollments', function($query) use ($batchIds) {
            $query->whereIn('batch_id', $batchIds);
        })->count();
    }
}