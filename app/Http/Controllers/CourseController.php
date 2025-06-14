<?php

namespace App\Http\Controllers;


use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Course;
use App\Models\Teacher;
use Illuminate\View\View;


class CourseController extends Controller
{

    public function index(): View
    {
        $Course = Course::all();
        return view ('courses.index')->with('courses', $Course);
    }

 
    public function create(Request $request): View
    {
        $teachers = Teacher::pluck('name', 'id');
        $selectedTeacherId = $request->query('teacher_id');
        return view('courses.create', compact('teachers', 'selectedTeacherId'));
    }

  
    public function store(Request $request): RedirectResponse
    {
        $input = $request->all();
        Course::create($input);
        return redirect('courses')->with('flash_message', 'courses Addedd!');
    }

    public function show(string $id): View
    {
        $course = Course::with(['batches.enrollments', 'teachers'])->find($id);
        return view('courses.show')->with('course', $course);
    }

    public function edit(string $id): View
    {
        $Course = Course::find($id);
        return view('courses.edit')->with('courses', $Course);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $Course = Course::find($id);
        $input = $request->all();
        $Course->update($input);
        return redirect('courses')->with('flash_message', 'courses Updated!');  
    }

    
    public function destroy(string $id): RedirectResponse
    {
        Course::destroy($id);
        return redirect('courses')->with('flash_message', 'courses deleted!'); 
    }
}