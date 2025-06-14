<?php
/**
 * DashboardController - Quản lý hiển thị trang tổng quan (Dashboard)
 * 
 * Controller này xử lý việc hiển thị trang tổng quan của hệ thống, bao gồm:
 * - Thống kê số lượng sinh viên, giáo viên, khóa học, lớp học, đăng ký và thanh toán
 * - Tính toán tổng doanh thu
 * - Hiển thị các biểu đồ và thông tin tổng quan khác
 * 
 * @package App\Http\Controllers
 */

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Enrollment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Hiển thị trang tổng quan (Dashboard)
     * 
     * Phương thức này tính toán các thống kê cần thiết và trả về view dashboard
     * với các dữ liệu tổng quan về hệ thống
     * 
     * @return \Illuminate\View\View View hiển thị trang tổng quan
     */
    public function index(): View
    {
        // Đếm số lượng sinh viên trong hệ thống
        // Sử dụng phương thức count() của Eloquent để đếm số bản ghi trong bảng students
        $studentCount = Student::count();
        
        // Đếm số lượng giáo viên trong hệ thống
        // Sử dụng toán tử null coalescing (??) để trả về 0 nếu kết quả là null
        $teacherCount = Teacher::count() ?? 0;
        
        // Đếm số lượng khóa học trong hệ thống
        $courseCount = Course::count() ?? 0;
        
        // Đếm số lượng lớp học trong hệ thống
        $batchCount = Batch::count() ?? 0;
        
        // Đếm số lượng đăng ký học trong hệ thống
        $enrollmentCount = Enrollment::count() ?? 0;
        
        // Đếm số lượng thanh toán trong hệ thống
        $paymentCount = Payment::count() ?? 0;
        
        // Tính tổng doanh thu từ tất cả các thanh toán
        // Sử dụng phương thức sum() để tính tổng cột 'amount' trong bảng payments
        $totalRevenue = Payment::sum('amount') ?? 0;
        
        // Có thể thêm các thống kê khác ở đây, ví dụ:
        // - Doanh thu theo tháng/năm
        // - Số lượng sinh viên mới trong tháng hiện tại
        // - Top khóa học có nhiều sinh viên đăng ký nhất
        // - Tỷ lệ thanh toán học phí
        
        // Trả về view 'dashboard.index' với các dữ liệu thống kê
        // Sử dụng hàm compact() để tạo mảng các biến để truyền vào view
        return view('dashboard.index', compact(
            'studentCount',    // Số lượng sinh viên
            'teacherCount',    // Số lượng giáo viên
            'courseCount',     // Số lượng khóa học
            'batchCount',      // Số lượng lớp học
            'enrollmentCount', // Số lượng đăng ký
            'paymentCount',    // Số lượng thanh toán
            'totalRevenue'     // Tổng doanh thu
        ));
    }
    
    /**
     * Có thể thêm các phương thức khác ở đây để xử lý các chức năng khác của dashboard
     * Ví dụ:
     * - getRevenueChart(): Lấy dữ liệu cho biểu đồ doanh thu
     * - getStudentStatistics(): Lấy thống kê chi tiết về sinh viên
     * - getRecentActivities(): Lấy danh sách các hoạt động gần đây
     */
}