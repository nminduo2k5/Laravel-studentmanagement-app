<?php
/**
 * Model Course - Quản lý thông tin khóa học
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
    use HasFactory;
    
    protected $table = 'courses';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'name',      // Tên khóa học
        'syllabus',  // Nội dung/giáo trình
        'duration'   // Thời lượng (tháng)
    ];

    /**
     * Trả về thời lượng khóa học với đơn vị "Months"
     */
    public function duration(): string
    {
        return $this->duration . " Months ";
    }
    
    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, 'teacher_course')
                    ->withPivot('role', 'is_primary')
                    ->withTimestamps();
    }
    
    public function primaryTeacher(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, 'teacher_course')
                    ->wherePivot('is_primary', true)
                    ->withPivot('role')
                    ->withTimestamps();
    }
    
    public function batches(): HasMany
    {
        return $this->hasMany(Batch::class);
    }
    
    /**
     * Lấy sinh viên đăng ký khóa học này qua các lớp học
     */
    public function students(): HasManyThrough
    {
        return $this->hasManyThrough(
            Student::class,
            Enrollment::class,
            'batch_id',
            'id',
            'id',
            'student_id'
        );
    }
    
    /**
     * Tính tổng doanh thu của khóa học
     */
    public function getTotalRevenueAttribute(): float
    {
        $totalRevenue = 0;
        
        foreach ($this->batches as $batch) {
            $totalRevenue += $batch->enrollments->sum('fees');
        }
        
        return $totalRevenue;
    }
}