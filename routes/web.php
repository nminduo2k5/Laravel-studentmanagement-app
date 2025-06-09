<?php
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Dashboard Route
Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

// Layout Route
Route::get('/layout', function () {
    return view('layout');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
});

// Resource Routes - Yêu cầu đăng nhập
Route::middleware(['auth'])->group(function () {
    Route::resource("/students", StudentController::class);
    Route::resource("/teachers", TeacherController::class);
    Route::resource("/courses", CourseController::class);
    Route::resource("/batches", BatchController::class);
    Route::resource("/enrollments", EnrollmentController::class);
    Route::resource("/payments", PaymentController::class);
});