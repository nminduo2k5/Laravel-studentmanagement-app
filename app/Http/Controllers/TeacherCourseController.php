<?php
/**
 * TeacherCourseController - Quản lý mối quan hệ giữa giáo viên và khóa học
 * 
 * Controller này xử lý các thao tác liên quan đến mối quan hệ nhiều-nhiều giữa giáo viên và khóa học:
 * - Hiển thị form gán giáo viên cho khóa học
 * - Lưu việc gán giáo viên cho khóa học
 * - Hiển thị danh sách khóa học của một giáo viên
 * 
 * @package App\Http\Controllers
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TeacherCourseController extends Controller
{
    /**
     * Hiển thị form để gán giáo viên cho khóa học
     * 
     * Phương thức này lấy thông tin khóa học, danh sách giáo viên và các giáo viên đã được gán
     * để hiển thị form gán giáo viên cho khóa học
     * 
     * @param string $courseId ID của khóa học
     * @return \Illuminate\View\View View hiển thị form gán giáo viên
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Nếu không tìm thấy khóa học
     */
    public function assignForm(string $courseId): View
    {
        // Tìm khóa học theo ID, nếu không tìm thấy sẽ ném ngoại lệ ModelNotFoundException
        $course = Course::findOrFail($courseId);
        
        // Lấy tất cả giáo viên từ cơ sở dữ liệu
        $teachers = Teacher::all();
        
        // Lấy danh sách ID của các giáo viên đã được gán cho khóa học này
        $assignedTeachers = $course->teachers()->pluck('teacher_id')->toArray();
        
        // Lấy giáo viên chính của khóa học (nếu có)
        $primaryTeacher = $course->primaryTeacher()->first();
        
        // Trả về view với các dữ liệu cần thiết
        return view('courses.assign_teachers', compact('course', 'teachers', 'assignedTeachers', 'primaryTeacher'));
    }
    
    /**
     * Lưu việc gán giáo viên cho khóa học
     * 
     * Phương thức này xác thực dữ liệu đầu vào, xóa các liên kết giáo viên hiện tại
     * và tạo các liên kết mới dựa trên dữ liệu form
     * 
     * @param \Illuminate\Http\Request $request Request chứa dữ liệu form
     * @param string $courseId ID của khóa học
     * @return \Illuminate\Http\RedirectResponse Chuyển hướng về trang chi tiết khóa học
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Nếu không tìm thấy khóa học
     */
    public function assign(Request $request, string $courseId): RedirectResponse
    {
        // Xác thực dữ liệu đầu vào
        $validated = $request->validate([
            'teacher_ids' => 'required|array',                // Danh sách ID giáo viên: bắt buộc, là mảng
            'teacher_ids.*' => 'exists:teachers,id',          // Mỗi ID giáo viên phải tồn tại trong bảng teachers
            'primary_teacher_id' => 'required|exists:teachers,id', // ID giáo viên chính: bắt buộc, phải tồn tại
            'roles' => 'array',                               // Vai trò của giáo viên: là mảng
            'roles.*' => 'nullable|string',                   // Mỗi vai trò có thể null, là chuỗi
        ]);
        
        // Tìm khóa học theo ID
        $course = Course::findOrFail($courseId);
        
        // Xóa tất cả các liên kết giáo viên hiện tại của khóa học
        $course->teachers()->detach();
        
        // Thêm các giáo viên được chọn vào khóa học
        foreach ($validated['teacher_ids'] as $teacherId) {
            // Kiểm tra xem giáo viên này có phải là giáo viên chính không
            $isPrimary = ($teacherId == $validated['primary_teacher_id']);
            
            // Lấy vai trò của giáo viên (nếu có)
            $role = isset($validated['roles'][$teacherId]) ? $validated['roles'][$teacherId] : null;
            
            // Tạo liên kết giữa khóa học và giáo viên với thông tin vai trò và trạng thái giáo viên chính
            $course->teachers()->attach($teacherId, [
                'role' => $role,
                'is_primary' => $isPrimary
            ]);
        }
        
        // Chuyển hướng về trang chi tiết khóa học với thông báo thành công
        return redirect()->route('courses.show', $courseId)
                         ->with('flash_message', 'Teachers have been assigned to the course!');
    }
    
    /**
     * Hiển thị các khóa học của một giáo viên
     * 
     * Phương thức này lấy thông tin giáo viên và các khóa học liên quan,
     * tính toán số lượng lớp học và sinh viên để hiển thị trang chi tiết
     * 
     * @param string $teacherId ID của giáo viên
     * @return \Illuminate\View\View View hiển thị danh sách khóa học của giáo viên
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Nếu không tìm thấy giáo viên
     */
    public function teacherCourses(string $teacherId): View
    {
        // Tìm giáo viên theo ID và eager loading các quan hệ liên quan
        $teacher = Teacher::with(['courses', 'primaryCourses'])->findOrFail($teacherId);
        
        // Lấy danh sách ID của các khóa học mà giáo viên dạy
        $courseIds = $teacher->courses->pluck('id')->toArray();
        
        // Đếm số lượng lớp học thuộc các khóa học đó
        $batchCount = Batch::whereIn('course_id', $courseIds)->count();
        
        // Lấy danh sách ID của các lớp học thuộc các khóa học đó
        $batchIds = Batch::whereIn('course_id', $courseIds)->pluck('id')->toArray();
        
        // Đếm số lượng sinh viên đã đăng ký vào các lớp học đó
        $studentCount = Student::whereHas('enrollments', function($query) use ($batchIds) {
            $query->whereIn('batch_id', $batchIds);
        })->count();
        
        // Trả về view với các dữ liệu cần thiết
        return view('teachers.courses', compact('teacher', 'batchCount', 'studentCount'));
    }
}