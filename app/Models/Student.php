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
}