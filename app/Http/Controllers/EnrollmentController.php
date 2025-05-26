<?php

namespace App\Http\Controllers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Enrollment;
use Illuminate\View\View;


class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enrollments = Enrollment::all();
        return view('enrollments.index')->with('enrollments', $enrollments);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('enrollments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        // Luôn chuyển đổi từ d/m/Y sang Y-m-d nếu có join_date
        if (!empty($input['join_date'])) {
            try {
                $input['join_date'] = \Carbon\Carbon::createFromFormat('d/m/Y', $input['join_date'])->format('Y-m-d');
            } catch (\Exception $e) {
                // Nếu đã là Y-m-d hoặc lỗi, không làm gì cả
            }
        }
        // Đảm bảo enroll_no có giá trị (không để trống)
        if (empty($input['enroll_no'])) {
            return redirect()->back()->withInput()->withErrors(['enroll_no' => 'Enroll No is required.']);
        }
        // Chỉ lấy đúng các trường cần thiết để insert
        $data = [
            'enroll_no' => $input['enroll_no'],
            'batch_id' => $input['batch_id'],
            'student_id' => $input['student_id'],
            'join_date' => $input['join_date'],
            'fees' => $input['fees'],
        ];
        Enrollment::create($data);
        return redirect('enrollments')->with('flash_message', 'Enrollment Added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $enrollment = Enrollment::find($id);
        return view('enrollments.show')->with('enrollments', $enrollment);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $enrollment = Enrollment::find($id);
        return view('enrollments.edit')->with('enrollments', $enrollment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $enrollment = Enrollment::find($id);
        $input = $request->all();
        // Đảm bảo join_date không bị null
        if (empty($input['join_date'])) {
            return redirect()->back()->withInput()->withErrors(['join_date' => 'Join Date is required.']);
        }
        // Luôn chuyển đổi từ d/m/Y sang Y-m-d nếu có join_date
        if (!empty($input['join_date'])) {
            try {
                $input['join_date'] = \Carbon\Carbon::createFromFormat('d/m/Y', $input['join_date'])->format('Y-m-d');
            } catch (\Exception $e) {
                // Nếu đã là Y-m-d hoặc lỗi, giữ nguyên không gán lại
            }
        }
        // Chỉ lấy đúng các trường cần thiết để update
        $data = [
            'enroll_no' => $input['enroll_no'],
            'batch_id' => $input['batch_id'],
            'student_id' => $input['student_id'],
            'join_date' => $input['join_date'],
            'fees' => $input['fees'],
        ];
        $enrollment->update($data);
        return redirect('enrollments')->with('flash_message', 'Enrollment Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Enrollment::destroy($id);
        return redirect('enrollments')->with('flash_message', 'Enrollment deleted!');
    }
}
