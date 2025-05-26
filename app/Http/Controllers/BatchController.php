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
    public function create()
    {
        $courses = Course::pluck('name', 'id');
        // Trả về view tạo mới với danh sách khóa học
        return view('batches.create',compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        // Xử lý course_id: nếu là số thì giữ nguyên, nếu là tên thì tìm ID
        if (!empty($input['course_id']) && !is_numeric($input['course_id'])) {
            $course = Course::where('name', $input['course_id'])->first();
            $input['course_id'] = $course ? $course->id : null;
        }
        // Luôn chuyển đổi từ d/m/Y sang Y-m-d
        if (!empty($input['start_date'])) {
            $input['start_date'] = Carbon::createFromFormat('d/m/Y', $input['start_date'])->format('Y-m-d');
        }
        Batch::create($input);
        return redirect('batches')->with('flash_message', 'Batch Addedd!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $batches = Batch::find($id);
        return view('batches.show')->with('batches', $batches);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $batches = Batch::find($id);
        return view('batches.edit')-> with('batches', $batches);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $batches = Batch::find($id);
        $input = $request->all();
        // Xử lý course_id: nếu là số thì giữ nguyên, nếu là tên thì tìm ID
        if (!empty($input['course_id']) && !is_numeric($input['course_id'])) {
            $course = Course::where('name', $input['course_id'])->first();
            $input['course_id'] = $course ? $course->id : null;
        }
        // Luôn chuyển đổi từ d/m/Y sang Y-m-d
        if (!empty($input['start_date'])) {
            $input['start_date'] = Carbon::createFromFormat('d/m/Y', $input['start_date'])->format('Y-m-d');
        }
        $batches->update($input);
        return redirect('batches')->with('flash_message', 'Batch Updated!');
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
