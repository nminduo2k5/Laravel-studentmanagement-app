<?php
/**
 * Model Course - Quản lý thông tin khóa học
 * 
 * Model này đại diện cho một khóa học trong hệ thống quản lý sinh viên.
 * Nó chứa thông tin về khóa học và các mối quan hệ với các bảng khác.
 * 
 * @package App\Models
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Course extends Model
{
    use HasFactory; // Sử dụng trait HasFactory để hỗ trợ tạo dữ liệu mẫu cho testing
    
    /**
     * Tên bảng trong cơ sở dữ liệu liên kết với model này
     * 
     * @var string
     */
    protected $table = 'courses';
    
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
        'name',      // Tên khóa học
        'syllabus',  // Nội dung/giáo trình khóa học
        'duration'   // Thời lượng khóa học (tính bằng tháng)
    ];

    /**
     * Trả về thời lượng khóa học dưới dạng chuỗi có đơn vị "Months"
     * 
     * Phương thức này được sử dụng để hiển thị thời lượng khóa học một cách thân thiện
     * 
     * @return string Thời lượng khóa học với đơn vị "Months"
     */
    public function duration(): string
    {
        return $this->duration . " Months ";
    }
    
    /**
     * Lấy tất cả các giáo viên dạy khóa học này
     * 
     * Quan hệ nhiều-nhiều: Một khóa học có thể được dạy bởi nhiều giáo viên
     * và một giáo viên có thể dạy nhiều khóa học
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, 'teacher_course')
                    ->withPivot('role', 'is_primary') // Lấy thêm thông tin về vai trò và trạng thái giáo viên chính
                    ->withTimestamps(); // Lưu thời gian tạo và cập nhật trong bảng trung gian
    }
    
    /**
     * Lấy giáo viên chính của khóa học
     * 
     * Quan hệ nhiều-nhiều với điều kiện: Chỉ lấy giáo viên có is_primary = true
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function primaryTeacher(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, 'teacher_course')
                    ->wherePivot('is_primary', true) // Chỉ lấy giáo viên chính
                    ->withPivot('role') // Lấy thêm thông tin về vai trò
                    ->withTimestamps(); // Lưu thời gian tạo và cập nhật trong bảng trung gian
    }
    
    /**
     * Lấy tất cả các lớp học thuộc khóa học này
     * 
     * Quan hệ một-nhiều: Một khóa học có thể có nhiều lớp học
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function batches(): HasMany
    {
        return $this->hasMany(Batch::class);
    }
    
    /**
     * Lấy tất cả sinh viên đăng ký khóa học này thông qua các lớp học
     * 
     * Quan hệ một-nhiều thông qua hai bảng trung gian:
     * Course -> Batch -> Enrollment -> Student
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function students(): HasManyThrough
    {
        return $this->hasManyThrough(
            Student::class,      // Model đích cuối cùng
            Enrollment::class,   // Model trung gian
            'batch_id',          // Khóa ngoại trên bảng enrollments liên kết với bảng batches
            'id',                // Khóa chính trên bảng students
            'id',                // Khóa chính trên bảng courses
            'student_id'         // Khóa ngoại trên bảng enrollments liên kết với bảng students
        );
    }
    
    /**
     * Tính tổng doanh thu của khóa học
     * 
     * Phương thức này tính tổng học phí từ tất cả các đăng ký vào các lớp học thuộc khóa học này
     * 
     * @return float Tổng doanh thu của khóa học
     */
    public function getTotalRevenueAttribute(): float
    {
        // Lấy tất cả các lớp học thuộc khóa học này
        $batches = $this->batches;
        
        // Khởi tạo biến tổng doanh thu
        $totalRevenue = 0;
        
        // Duyệt qua từng lớp học
        foreach ($batches as $batch) {
            // Cộng dồn học phí từ tất cả các đăng ký vào lớp học này
            $totalRevenue += $batch->enrollments->sum('fees');
        }
        
        return $totalRevenue;
    }
}
