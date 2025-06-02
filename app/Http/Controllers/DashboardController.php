<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Enrollment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Đếm số lượng các đối tượng
        $studentCount = Student::count();
        $teacherCount = Teacher::count() ?? 0;
        $courseCount = Course::count() ?? 0;
        $batchCount = Batch::count() ?? 0;
        $enrollmentCount = Enrollment::count() ?? 0;
        $paymentCount = Payment::count() ?? 0;
        
        // Tính tổng doanh thu (nếu có bảng Payment)
        $totalRevenue = Payment::sum('amount') ?? 0;
        
        return view('dashboard.index', compact(
            'studentCount', 
            'teacherCount', 
            'courseCount', 
            'batchCount', 
            'enrollmentCount', 
            'paymentCount', 
            'totalRevenue'
        ));
    }
    

}