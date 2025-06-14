<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    
    protected $table = 'students';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'address', 'mobile', 'gpa'];
    
    /**
     * Lấy các đăng ký của sinh viên
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    
    /**
     * Lấy các thanh toán của sinh viên
     */
    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Enrollment::class);
    }
    
    /**
     * Lấy các lớp học mà sinh viên đã đăng ký
     */
    public function batches()
    {
        return $this->belongsToMany(Batch::class, 'enrollments');
    }
    
    /**
     * Lấy các khóa học mà sinh viên đã đăng ký
     */
    public function courses()
    {
        return $this->hasManyThrough(
            Course::class,
            Enrollment::class,
            'student_id', // Khóa ngoại trên enrollments
            'id', // Khóa chính trên courses
            'id', // Khóa chính trên students
            'batch_id' // Khóa ngoại trên enrollments
        );
    }
}