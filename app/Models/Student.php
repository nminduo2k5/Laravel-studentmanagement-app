<?php
/**
 * Model Student - Quản lý thông tin sinh viên
 * 
 * Model này đại diện cho một sinh viên trong hệ thống quản lý sinh viên.
 * Nó chứa thông tin cá nhân của sinh viên và các mối quan hệ với các bảng khác.
 * 
 * @package App\Models
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    /**
     * Tên bảng trong cơ sở dữ liệu
     * @var string
     */
    protected $table = 'students';

    /**
     * Khóa chính của bảng
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Các trường có thể gán hàng loạt
     * @var array
     */
    protected $fillable = ['name', 'address', 'mobile', 'gpa'];

    /**
     * Một sinh viên có nhiều đăng ký học
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Một sinh viên có nhiều thanh toán thông qua các đăng ký
     */
    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Enrollment::class);
    }

    /**
     * Một sinh viên đăng ký nhiều lớp học (nhiều-nhiều)
     */
    public function batches()
    {
        return $this->belongsToMany(Batch::class, 'enrollments');
    }

    /**
     * Lấy tất cả các khóa học mà sinh viên đã đăng ký
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