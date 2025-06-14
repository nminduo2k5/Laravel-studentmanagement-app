<?php
/**
 * Model Batch - Quản lý thông tin lớp học
 * 
 * Model này đại diện cho một lớp học trong hệ thống quản lý sinh viên.
 * Mỗi lớp học thuộc về một khóa học cụ thể và có thể có nhiều sinh viên đăng ký.
 * 
 * @package App\Models
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;

class Batch extends Model
{
    use HasFactory; // Sử dụng trait HasFactory để hỗ trợ tạo dữ liệu mẫu cho testing
    
    /**
     * Tên bảng trong cơ sở dữ liệu liên kết với model này
     * 
     * @var string
     */
    protected $table = 'batches';
    
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
        'name',       // Tên lớp học
        'course_id',  // ID của khóa học mà lớp học này thuộc về
        'start_date'  // Ngày bắt đầu lớp học
    ];
    
    /**
     * Các trường nên được chuyển đổi thành các kiểu dữ liệu cụ thể
     * 
     * @var array
     */
    protected $casts = [
        'start_date' => 'date', // Chuyển đổi trường start_date thành kiểu date
    ];
    
    /**
     * Lấy khóa học mà lớp học này thuộc về
     * 
     * Quan hệ nhiều-một: Nhiều lớp học có thể thuộc về một khóa học
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
    
    /**
     * Lấy tất cả các đăng ký vào lớp học này
     * 
     * Quan hệ một-nhiều: Một lớp học có thể có nhiều đăng ký
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }
    
    /**
     * Lấy tất cả sinh viên đã đăng ký vào lớp học này
     * 
     * Quan hệ nhiều-nhiều thông qua bảng enrollments: Một lớp học có thể có nhiều sinh viên
     * và một sinh viên có thể đăng ký nhiều lớp học
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'enrollments');
    }
    
    /**
     * Kiểm tra xem lớp học đã bắt đầu chưa
     * 
     * @return bool True nếu lớp học đã bắt đầu, False nếu chưa
     */
    public function hasStarted(): bool
    {
        return Carbon::parse($this->start_date)->isPast();
    }
    
    /**
     * Tính tổng học phí của lớp học
     * 
     * @return float Tổng học phí của tất cả đăng ký vào lớp học này
     */
    public function getTotalFeesAttribute(): float
    {
        return $this->enrollments->sum('fees');
    }
    
    /**
     * Tính tổng số tiền đã thanh toán cho lớp học
     * 
     * @return float Tổng số tiền đã thanh toán
     */
    public function getTotalPaidAttribute(): float
    {
        $totalPaid = 0;
        
        foreach ($this->enrollments as $enrollment) {
            $totalPaid += $enrollment->payments->sum('amount');
        }
        
        return $totalPaid;
    }
    
    /**
     * Tính tỷ lệ thanh toán của lớp học
     * 
     * @return float Tỷ lệ thanh toán (0-100%)
     */
    public function getPaymentRateAttribute(): float
    {
        $totalFees = $this->total_fees;
        
        if ($totalFees <= 0) {
            return 0;
        }
        
        return ($this->total_paid / $totalFees) * 100;
    }
}
