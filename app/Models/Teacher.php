<?php
/**
 * Model Teacher - Quản lý thông tin giáo viên
 * 
 * Model này đại diện cho một giáo viên trong hệ thống quản lý sinh viên.
 * Nó chứa thông tin cá nhân của giáo viên, thông tin chuyên môn và các mối quan hệ với các bảng khác.
 * 
 * @package App\Models
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory; // Sử dụng trait HasFactory để hỗ trợ tạo dữ liệu mẫu cho testing
    
    /**
     * Tên bảng trong cơ sở dữ liệu liên kết với model này
     * 
     * @var string
     */
    protected $table = 'teachers';
    
    /**
     * Khóa chính của bảng
     * 
     * @var string
     */
    protected $primaryKey = 'id';
    
    /**
     * Các trường có thể được gán hàng loạt (mass assignable)
     * 
     * @var array
     */
    protected $fillable = [
        'name',             // Tên giáo viên
        'address',          // Địa chỉ
        'mobile',           // Số điện thoại
        'specialization',   // Chuyên môn
        'experience',       // Số năm kinh nghiệm
        'qualification',    // Bằng cấp
        'join_date'         // Ngày bắt đầu làm việc
    ];
    
    /**
     * Lấy tất cả các khóa học mà giáo viên dạy
     * 
     * Quan hệ nhiều-nhiều: Một giáo viên có thể dạy nhiều khóa học và một khóa học có thể được dạy bởi nhiều giáo viên
     * Sử dụng bảng trung gian 'teacher_course' để lưu trữ mối quan hệ này
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'teacher_course')
                    ->withPivot('role', 'is_primary') // Lấy thêm thông tin về vai trò và trạng thái giáo viên chính
                    ->withTimestamps(); // Lưu thời gian tạo và cập nhật trong bảng trung gian
    }
    
    /**
     * Lấy các khóa học mà giáo viên là giáo viên chính
     * 
     * Lọc các khóa học mà giáo viên này là giáo viên chính (is_primary = true)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function primaryCourses()
    {
        return $this->belongsToMany(Course::class, 'teacher_course')
                    ->wherePivot('is_primary', true) // Chỉ lấy các khóa học mà giáo viên là giáo viên chính
                    ->withPivot('role') // Lấy thêm thông tin về vai trò
                    ->withTimestamps(); // Lưu thời gian tạo và cập nhật trong bảng trung gian
    }
    
    /**
     * Lấy các lớp học (batches) mà giáo viên dạy thông qua khóa học
     * 
     * Đây là một accessor (không phải relationship) để lấy danh sách các lớp học
     * mà giáo viên dạy thông qua các khóa học được phân công
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getBatchesAttribute()
    {
        // Lấy danh sách ID của các khóa học mà giáo viên dạy
        $courseIds = $this->courses()->pluck('courses.id')->toArray();
        
        // Truy vấn các lớp học thuộc các khóa học đó
        return Batch::whereIn('course_id', $courseIds)->get();
    }
    
    /**
     * Đếm số lượng lớp học (batches) mà giáo viên dạy
     * 
     * Đây là một accessor để đếm số lượng lớp học mà giáo viên dạy
     * thông qua các khóa học được phân công
     * 
     * @return int
     */
    public function getBatchesCountAttribute()
    {
        // Lấy danh sách ID của các khóa học mà giáo viên dạy
        $courseIds = $this->courses()->pluck('courses.id')->toArray();
        
        // Đếm số lượng lớp học thuộc các khóa học đó
        return Batch::whereIn('course_id', $courseIds)->count();
    }
    
    /**
     * Lấy danh sách sinh viên mà giáo viên dạy
     * 
     * Đây là một accessor để lấy danh sách sinh viên mà giáo viên dạy
     * thông qua các lớp học của các khóa học được phân công
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getStudentsAttribute()
    {
        // Lấy danh sách ID của các khóa học mà giáo viên dạy
        $courseIds = $this->courses()->pluck('courses.id')->toArray();
        
        // Lấy danh sách ID của các lớp học thuộc các khóa học đó
        $batchIds = Batch::whereIn('course_id', $courseIds)->pluck('id')->toArray();
        
        // Truy vấn các sinh viên đã đăng ký vào các lớp học đó
        return Student::whereHas('enrollments', function($query) use ($batchIds) {
            $query->whereIn('batch_id', $batchIds);
        })->get();
    }
    
    /**
     * Đếm số lượng sinh viên mà giáo viên dạy
     * 
     * Đây là một accessor để đếm số lượng sinh viên mà giáo viên dạy
     * thông qua các lớp học của các khóa học được phân công
     * 
     * @return int
     */
    public function getStudentsCountAttribute()
    {
        // Lấy danh sách ID của các khóa học mà giáo viên dạy
        $courseIds = $this->courses()->pluck('courses.id')->toArray();
        
        // Lấy danh sách ID của các lớp học thuộc các khóa học đó
        $batchIds = Batch::whereIn('course_id', $courseIds)->pluck('id')->toArray();
        
        // Đếm số lượng sinh viên đã đăng ký vào các lớp học đó
        return Student::whereHas('enrollments', function($query) use ($batchIds) {
            $query->whereIn('batch_id', $batchIds);
        })->count();
    }
}