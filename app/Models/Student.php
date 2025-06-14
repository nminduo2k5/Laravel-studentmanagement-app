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
    use HasFactory; // Sử dụng trait HasFactory để hỗ trợ tạo dữ liệu mẫu cho testing
    
    /**
     * Tên bảng trong cơ sở dữ liệu liên kết với model này
     * 
     * @var string
     */
    protected $table = 'students';
    
    /**
     * Khóa chính của bảng
     * 
     * @var string
     */
    protected $primaryKey = 'id';
    
    /**
     * Các trường có thể được gán hàng loạt (mass assignable)
     * Chỉ những trường được liệt kê ở đây mới có thể được cập nhật thông qua phương thức create() hoặc update()
     * 
     * @var array
     */
    protected $fillable = ['name', 'address', 'mobile', 'gpa'];
    
    /**
     * Lấy tất cả các đăng ký của sinh viên
     * 
     * Quan hệ một-nhiều: Một sinh viên có thể có nhiều đăng ký học
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    
    /**
     * Lấy tất cả các thanh toán của sinh viên thông qua đăng ký
     * 
     * Quan hệ một-nhiều thông qua bảng trung gian: Một sinh viên có thể có nhiều thanh toán thông qua các đăng ký
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Enrollment::class);
    }
    
    /**
     * Lấy tất cả các lớp học mà sinh viên đã đăng ký
     * 
     * Quan hệ nhiều-nhiều thông qua bảng enrollments: Một sinh viên có thể đăng ký nhiều lớp học
     * và một lớp học có thể có nhiều sinh viên
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function batches()
    {
        return $this->belongsToMany(Batch::class, 'enrollments');
    }
    
    /**
     * Lấy tất cả các khóa học mà sinh viên đã đăng ký
     * 
     * Quan hệ một-nhiều thông qua hai bảng trung gian: 
     * Student -> Enrollment -> Batch -> Course
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function courses()
    {
        return $this->hasManyThrough(
            Course::class,         // Model đích cuối cùng
            Enrollment::class,     // Model trung gian
            'student_id',          // Khóa ngoại trên bảng enrollments liên kết với bảng students
            'id',                  // Khóa chính trên bảng courses
            'id',                  // Khóa chính trên bảng students
            'batch_id'             // Khóa ngoại trên bảng enrollments liên kết với bảng batches
        );
    }
}