<?php

namespace App\Http\Controllers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Batch;
use Illuminate\View\View;


class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $enrollments = Enrollment::with(['student', 'batch.course'])->get();
        return view('enrollments.index')->with('enrollments', $enrollments);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $students = Student::pluck('name', 'id');
        $batches = Batch::with('course')
            ->get()
            ->map(function($batch) {
                return [
                    'id' => $batch->id,
                    'name' => $batch->name . ' - ' . ($batch->course ? $batch->course->name : 'N/A')
                ];
            })
            ->pluck('name', 'id');
        return view('enrollments.create', compact('students', 'batches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'enroll_no' => 'required|string|max:50|unique:enrollments',
            'batch_id' => 'required|exists:batches,id',
            'student_id' => 'required|exists:students,id',
            'join_date' => 'required|date',
            'fees' => 'required|numeric|min:0',
            'midterm_grade' => 'nullable|numeric|min:0|max:10',
            'final_grade' => 'nullable|numeric|min:0|max:10',
            'assignment_grade' => 'nullable|numeric|min:0|max:10',
            'grade_remarks' => 'nullable|string',
        ]);
        
        // Calculate total grade if all components are present
        if (isset($validated['midterm_grade']) && isset($validated['final_grade']) && isset($validated['assignment_grade'])) {
            $validated['total_grade'] = 
                ($validated['midterm_grade'] * 0.3) + 
                ($validated['final_grade'] * 0.5) + 
                ($validated['assignment_grade'] * 0.2);
        }
        
        $enrollment = Enrollment::create($validated);
        
        // Tự động tính lại GPA cho sinh viên nếu có điểm
        if (isset($validated['total_grade'])) {
            $enrollment->student->calculateGPA();
        }
        
        return redirect('enrollments')->with('flash_message', 'Enrollment Added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $enrollment = Enrollment::with(['student', 'batch.course', 'payments'])->find($id);
        return view('enrollments.show')->with('enrollment', $enrollment);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $enrollment = Enrollment::find($id);
        $students = Student::pluck('name', 'id');
        $batches = Batch::with('course')
            ->get()
            ->map(function($batch) {
                return [
                    'id' => $batch->id,
                    'name' => $batch->name . ' - ' . ($batch->course ? $batch->course->name : 'N/A')
                ];
            })
            ->pluck('name', 'id');
        return view('enrollments.edit', compact('enrollment', 'students', 'batches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'enroll_no' => 'required|string|max:50|unique:enrollments,enroll_no,'.$id,
            'batch_id' => 'required|exists:batches,id',
            'student_id' => 'required|exists:students,id',
            'join_date' => 'required|date',
            'fees' => 'required|numeric|min:0',
            'midterm_grade' => 'nullable|numeric|min:0|max:10',
            'final_grade' => 'nullable|numeric|min:0|max:10',
            'assignment_grade' => 'nullable|numeric|min:0|max:10',
            'grade_remarks' => 'nullable|string',
        ]);
        
        // Calculate total grade if all components are present
        if (isset($validated['midterm_grade']) && isset($validated['final_grade']) && isset($validated['assignment_grade'])) {
            $validated['total_grade'] = 
                ($validated['midterm_grade'] * 0.3) + 
                ($validated['final_grade'] * 0.5) + 
                ($validated['assignment_grade'] * 0.2);
        }
        
        $enrollment = Enrollment::find($id);
        $enrollment->update($validated);
        
        // Tự động tính lại GPA cho sinh viên
        $enrollment->student->calculateGPA();
        
        return redirect('enrollments')->with('flash_message', 'Enrollment Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        Enrollment::destroy($id);
        return redirect('enrollments')->with('flash_message', 'Enrollment deleted!');
    }
    
    /**
     * Show form for entering grades for a student enrollment.
     */
    public function showGradeForm(string $id): View
    {
        $enrollment = Enrollment::with(['student', 'batch.course'])->find($id);
        return view('enrollments.grades', compact('enrollment'));
    }
    
    /**
     * Save grades for a student enrollment.
     */
    public function saveGrades(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'midterm_grade' => 'nullable|numeric|min:0|max:10',
            'final_grade' => 'nullable|numeric|min:0|max:10',
            'assignment_grade' => 'nullable|numeric|min:0|max:10',
            'grade_remarks' => 'nullable|string',
        ]);
        
        $enrollment = Enrollment::find($id);
        
        // Calculate total grade if all components are present
        if (isset($validated['midterm_grade']) && isset($validated['final_grade']) && isset($validated['assignment_grade'])) {
            $validated['total_grade'] = 
                ($validated['midterm_grade'] * 0.3) + 
                ($validated['final_grade'] * 0.5) + 
                ($validated['assignment_grade'] * 0.2);
        }
        
        $enrollment->update($validated);
        
        // Tự động tính lại GPA cho sinh viên
        $enrollment->student->calculateGPA();
        
        return redirect()->route('enrollments.show', $id)->with('flash_message', 'Điểm số đã được cập nhật!');
    }
}
