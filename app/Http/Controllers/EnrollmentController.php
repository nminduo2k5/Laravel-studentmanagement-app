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
        ]);
        
        Enrollment::create($validated);
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
        ]);
        
        $enrollment = Enrollment::find($id);
        $enrollment->update($validated);
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
}
