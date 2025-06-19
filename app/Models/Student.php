<?php
/**
 * Model Student - Quản lý thông tin sinh viên
 * @package App\Models
 */

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
     * Lấy danh sách đăng ký học của sinh viên
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Lấy lịch sử thanh toán của sinh viên
     */
    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Enrollment::class);
    }

    /**
     * Lấy các lớp học sinh viên đã đăng ký
     */
    public function batches()
    {
        return $this->belongsToMany(Batch::class, 'enrollments');
    }

    /**
     * Lấy các khóa học sinh viên đã tham gia
     */
    public function courses()
    {
        return $this->hasManyThrough(
            Course::class,
            Enrollment::class,
            'student_id',
            'id',
            'id',
            'batch_id'
        );
    }

    /**
     * Tính GPA từ điểm số trong enrollments (thang điểm 4)
     */
    public function calculateGPA()
    {
        $enrollments = $this->enrollments()->whereNotNull('total_grade')->get();
        
        if ($enrollments->isEmpty()) {
            return 0;
        }
        
        $totalGradePoints = 0;
        foreach ($enrollments as $enrollment) {
            $totalGradePoints += $this->convertToGPA4Scale($enrollment->total_grade);
        }
        
        $gpa = $totalGradePoints / $enrollments->count();
        
        // Cập nhật GPA vào database
        $this->update(['gpa' => round($gpa, 2)]);
        
        return round($gpa, 2);
    }

    /**
     * Quy đổi điểm từ thang 10 sang thang 4
     */
    private function convertToGPA4Scale($grade)
    {
        if ($grade >= 8.5) return 4.0;
        if ($grade >= 7.0) return 3.0;
        if ($grade >= 5.5) return 2.0;
        if ($grade >= 4.0) return 1.0;
        return 0.0;
    }
}