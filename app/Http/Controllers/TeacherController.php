<?php

namespace App\Http\Controllers;


use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Teacher;
use Illuminate\View\View;


class TeacherController extends Controller
{

    public function index(): View
    {
        $teachers = Teacher::all();
        return view('teachers.index')->with('teachers', $teachers);
    }

 
    public function create(): View
    {
        return view('teachers.create');
    }

  
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string',
            'mobile' => 'required|string|max:20',
            'specialization' => 'nullable|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'experience' => 'nullable|integer|min:0',
            'join_date' => 'nullable|date',
        ]);
        
        $teacher = Teacher::create($validated);
        return redirect('teachers')->with('flash_message', 'Giáo viên đã được thêm thành công!');
    }

    public function show(string $id): View
    {
        $teacher = Teacher::with(['courses', 'primaryCourses'])->find($id);
        
        // Tính toán số lượng batch và student để tránh lỗi
        $courseIds = $teacher->courses->pluck('id')->toArray();
        $batchCount = \App\Models\Batch::whereIn('course_id', $courseIds)->count();
        
        return view('teachers.show', compact('teacher', 'batchCount'));
    }

    public function edit(string $id): View
    {
        $teacher = Teacher::find($id);
        return view('teachers.edit')->with('teacher', $teacher);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string',
            'mobile' => 'required|string|max:20',
            'specialization' => 'nullable|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'experience' => 'nullable|integer|min:0',
            'join_date' => 'nullable|date',
        ]);
        
        $teacher = Teacher::find($id);
        $teacher->update($validated);
        return redirect('teachers')->with('flash_message', 'Thông tin giáo viên đã được cập nhật!');  
    }

    
    public function destroy(string $id): RedirectResponse
    {
        Teacher::destroy($id);
        return redirect('teachers')->with('flash_message', 'Teacher deleted!'); 
    }
}