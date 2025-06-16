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
Route::middleware('guest')->group(function () {
    // Hiển thị form đăng ký
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    // Xử lý đăng ký
    Route::post('/register', [AuthController::class, 'register']);
    // Hiển thị form đăng nhập
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    // Xử lý đăng nhập
    Route::post('/login', [AuthController::class, 'login']);
});

// ==================== Các route yêu cầu đăng nhập ====================
// Chỉ truy cập được khi đã đăng nhập (auth)
Route::middleware('auth')->group(function () {
    // Đăng xuất
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    // Xem thông tin cá nhân
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    // Cập nhật thông tin cá nhân
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

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
});