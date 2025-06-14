<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TeacherCourseController extends Controller
{
    /**
     * Hiển thị form để gán giáo viên cho khóa học
     */
    public function assignForm(string $courseId): View
    {
        $course = Course::findOrFail($courseId);
        $teachers = Teacher::all();
        $assignedTeachers = $course->teachers()->pluck('teacher_id')->toArray();
        $primaryTeacher = $course->primaryTeacher()->first();
        
        return view('courses.assign_teachers', compact('course', 'teachers', 'assignedTeachers', 'primaryTeacher'));
    }
    
    /**
     * Lưu việc gán giáo viên cho khóa học
     */
    public function assign(Request $request, string $courseId): RedirectResponse
    {
        $validated = $request->validate([
            'teacher_ids' => 'required|array',
            'teacher_ids.*' => 'exists:teachers,id',
            'primary_teacher_id' => 'required|exists:teachers,id',
            'roles' => 'array',
            'roles.*' => 'nullable|string',
        ]);
        
        $course = Course::findOrFail($courseId);
        
        // Xóa tất cả các liên kết hiện tại
        $course->teachers()->detach();
        
        // Thêm các giáo viên được chọn
        foreach ($validated['teacher_ids'] as $teacherId) {
            $isPrimary = ($teacherId == $validated['primary_teacher_id']);
            $role = isset($validated['roles'][$teacherId]) ? $validated['roles'][$teacherId] : null;
            
            $course->teachers()->attach($teacherId, [
                'role' => $role,
                'is_primary' => $isPrimary
            ]);
        }
        
        return redirect()->route('courses.show', $courseId)
                         ->with('flash_message', 'Giáo viên đã được gán cho khóa học!');
    }
    
    /**
     * Hiển thị các khóa học của một giáo viên
     */
    public function teacherCourses(string $teacherId): View
    {
        $teacher = Teacher::with(['courses', 'primaryCourses'])->findOrFail($teacherId);
        
        // Tính toán số lượng batch và student để tránh lỗi
        $courseIds = $teacher->courses->pluck('id')->toArray();
        $batchCount = \App\Models\Batch::whereIn('course_id', $courseIds)->count();
        $batchIds = \App\Models\Batch::whereIn('course_id', $courseIds)->pluck('id')->toArray();
        $studentCount = \App\Models\Student::whereHas('enrollments', function($query) use ($batchIds) {
            $query->whereIn('batch_id', $batchIds);
        })->count();
        
        return view('teachers.courses', compact('teacher', 'batchCount', 'studentCount'));
    }
}