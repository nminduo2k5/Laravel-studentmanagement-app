<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Models\Batch;
use App\Models\Course;
use Illuminate\View\View;
use Carbon\Carbon;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $batches = Batch::all();
        return view ('batches.index')->with('batches', $batches);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $courses = Course::pluck('name', 'id');
        $selectedCourseId = $request->query('course_id');
        // Trả về view tạo mới với danh sách khóa học và khóa học được chọn sẵn
        return view('batches.create', compact('courses', 'selectedCourseId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'start_date' => 'required|date',
        ]);
        
        $input = $request->all();
        Batch::create($input);
        return redirect('batches')->with('flash_message', 'Lớp học đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $batches = Batch::with(['course.teachers', 'enrollments.student', 'enrollments.payments'])->find($id);
        return view('batches.show')->with('batches', $batches);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $batches = Batch::find($id);
        $courses = Course::pluck('name', 'id');
        return view('batches.edit', compact('batches', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'start_date' => 'required|date',
        ]);
        
        $batches = Batch::find($id);
        $input = $request->all();
        
        // Không cần xử lý course_id vì đã validate là exists:courses,id
        
        // Không cần xử lý start_date vì đã sử dụng input type="date"
        
        $batches->update($input);
        return redirect('batches')->with('flash_message', 'Lớp học đã được cập nhật!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Batch::destroy($id);
        return redirect('batches')->with('flash_message', 'Batch deleted!');
    }
}
