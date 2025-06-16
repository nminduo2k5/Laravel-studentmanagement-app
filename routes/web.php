<?php
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// ==================== Trang tổng quan (Dashboard) ====================
Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

// ==================== Trang layout mẫu (dùng cho test giao diện) ====================
Route::get('/layout', function () {
    return view('layout');
});

// ==================== Các route dành cho khách (chưa đăng nhập) ====================
// Chỉ truy cập được khi chưa đăng nhập (guest)
// Các route xác thực được xử lý tự động bởi Laravel Fortify

// ==================== Các route yêu cầu đăng nhập ====================
// Chỉ truy cập được khi đã đăng nhập (auth)
Route::middleware('auth')->group(function () {
    // Xem thông tin cá nhân (Fortify xử lý đăng xuất và cập nhật thông tin)
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');

    // ==================== Các route resource (CRUD) ====================
    // Quản lý sinh viên, giáo viên, khóa học, lớp, ghi danh, thanh toán
    Route::resources([
        'students' => StudentController::class,      // Quản lý sinh viên
        'teachers' => TeacherController::class,      // Quản lý giáo viên
        'courses' => CourseController::class,        // Quản lý khóa học
        'batches' => BatchController::class,         // Quản lý lớp/batch
        'enrollments' => EnrollmentController::class,// Quản lý ghi danh
        'payments' => PaymentController::class,      // Quản lý thanh toán
    ]);
    
    // ==================== Các route quản lý mối quan hệ giữa Teacher và Course ====================
    Route::get('/courses/{course}/assign-teachers', [App\Http\Controllers\TeacherCourseController::class, 'assignForm'])->name('courses.assign.teachers.form');
    Route::post('/courses/{course}/assign-teachers', [App\Http\Controllers\TeacherCourseController::class, 'assign'])->name('courses.assign.teachers');
    Route::get('/teachers/{teacher}/courses', [App\Http\Controllers\TeacherCourseController::class, 'teacherCourses'])->name('teachers.courses');
    
    // ==================== Các route quản lý điểm số của sinh viên ====================
    Route::get('/enrollments/{enrollment}/grades', [EnrollmentController::class, 'showGradeForm'])->name('enrollments.grades.form');
    Route::post('/enrollments/{enrollment}/grades', [EnrollmentController::class, 'saveGrades'])->name('enrollments.grades.save');
    
    // ==================== Các route quản lý GPA của sinh viên ====================
    Route::get('/students/gpa', [StudentGpaController::class, 'index'])->name('students.gpa');
    Route::get('/students/update-all-gpa', [StudentGpaController::class, 'updateAllGPA'])->name('students.update-all-gpa');
    
    // ==================== Cập nhật GPA của sinh viên ====================
    Route::get('/students/update-gpa', [StudentController::class, 'updateAllGPA'])->name('students.update-gpa');
});