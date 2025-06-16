<?php
/**
 * Model Batch - Quản lý thông tin lớp học
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
    use HasFactory;
    
    protected $table = 'batches';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'name',       // Tên lớp học
        'course_id',  // ID khóa học
        'start_date'  // Ngày bắt đầu
    ];
    
    protected $casts = [
        'start_date' => 'date',
    ];
    
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
    
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }
    
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'enrollments');
    }
    
    /**
     * Kiểm tra xem lớp học đã bắt đầu chưa
     */
    public function hasStarted(): bool
    {
        return Carbon::parse($this->start_date)->isPast();
    }
    
    /**
     * Tính tổng học phí của lớp học
     */
    public function getTotalFeesAttribute(): float
    {
        return $this->enrollments->sum('fees');
    }
    
    /**
     * Tính tổng số tiền đã thanh toán
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
     * Tính tỷ lệ thanh toán (0-100%)
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