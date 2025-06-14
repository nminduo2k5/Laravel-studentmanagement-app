<?php
/**
 * StudentController - Quản lý các thao tác CRUD cho sinh viên
 * 
 * Controller này xử lý tất cả các thao tác liên quan đến sinh viên như:
 * - Hiển thị danh sách sinh viên
 * - Tạo sinh viên mới
 * - Hiển thị thông tin chi tiết sinh viên
 * - Cập nhật thông tin sinh viên
 * - Xóa sinh viên
 * 
 * @package App\Http\Controllers
 */

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Student;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Hiển thị danh sách tất cả sinh viên
     * 
     * Phương thức này lấy tất cả sinh viên từ cơ sở dữ liệu và trả về view hiển thị danh sách
     * 
     * @return \Illuminate\View\View View hiển thị danh sách sinh viên
     */
    public function index(): View
    {
        // Lấy tất cả sinh viên từ cơ sở dữ liệu
        $students = Student::all();
        
        // Trả về view 'students.index' với dữ liệu sinh viên
        return view('students.index')->with('students', $students);
    }

    /**
     * Hiển thị form tạo sinh viên mới
     * 
     * @return \Illuminate\View\View View chứa form tạo sinh viên mới
     */
    public function create(): View
    {
        // Trả về view 'students.create' chứa form tạo sinh viên mới
        return view('students.create');
    }

    /**
     * Lưu thông tin sinh viên mới vào cơ sở dữ liệu
     * 
     * Phương thức này xác thực dữ liệu đầu vào, tạo sinh viên mới và chuyển hướng người dùng
     * 
     * @param \Illuminate\Http\Request $request Request chứa dữ liệu form
     * @return \Illuminate\Http\RedirectResponse Chuyển hướng về trang danh sách sinh viên
     */
    public function store(Request $request): RedirectResponse
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',     // Tên: bắt buộc, chuỗi, tối đa 255 ký tự
            'gpa' => 'nullable|numeric|between:0,4.00', // GPA: có thể null, số, giữa 0 và 4.00
            'address' => 'required|string',          // Địa chỉ: bắt buộc, chuỗi
            'mobile' => 'required|string'            // Số điện thoại: bắt buộc, chuỗi
        ]);
        
        // Lấy tất cả dữ liệu từ request
        $input = $request->all();
        
        // Tạo sinh viên mới với dữ liệu đã xác thực
        Student::create($input);
        
        // Chuyển hướng về trang danh sách sinh viên với thông báo thành công
        return redirect('students')->with('flash_message', 'Student Added!');
    }

    /**
     * Hiển thị thông tin chi tiết của một sinh viên
     * 
     * Phương thức này lấy thông tin sinh viên theo ID, bao gồm các thông tin liên quan như
     * đăng ký học, lớp học, khóa học và thanh toán
     * 
     * @param string $id ID của sinh viên
     * @return \Illuminate\View\View View hiển thị thông tin chi tiết sinh viên
     */
    public function show(string $id): View
    {
        // Tìm sinh viên theo ID và eager loading các quan hệ liên quan
        $student = Student::with([
            'enrollments.batch.course',  // Lấy thông tin đăng ký, lớp học và khóa học
            'enrollments.payments',      // Lấy thông tin thanh toán cho mỗi đăng ký
            'payments'                   // Lấy tất cả thanh toán của sinh viên
        ])->find($id);
        
        // Trả về view 'students.show' với dữ liệu sinh viên
        return view('students.show')->with('students', $student);
    }

    /**
     * Hiển thị form chỉnh sửa thông tin sinh viên
     * 
     * @param string $id ID của sinh viên
     * @return \Illuminate\View\View View chứa form chỉnh sửa thông tin sinh viên
     */
    public function edit(string $id): View
    {
        // Tìm sinh viên theo ID
        $student = Student::find($id);
        
        // Trả về view 'students.edit' với dữ liệu sinh viên
        return view('students.edit')->with('students', $student);
    }

    /**
     * Cập nhật thông tin sinh viên trong cơ sở dữ liệu
     * 
     * Phương thức này xác thực dữ liệu đầu vào, cập nhật thông tin sinh viên và chuyển hướng người dùng
     * 
     * @param \Illuminate\Http\Request $request Request chứa dữ liệu form
     * @param string $id ID của sinh viên
     * @return \Illuminate\Http\RedirectResponse Chuyển hướng về trang danh sách sinh viên
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',     // Tên: bắt buộc, chuỗi, tối đa 255 ký tự
            'gpa' => 'nullable|numeric|between:0,4.00', // GPA: có thể null, số, giữa 0 và 4.00
            'address' => 'required|string',          // Địa chỉ: bắt buộc, chuỗi
            'mobile' => 'required|string'            // Số điện thoại: bắt buộc, chuỗi
        ]);
        
        // Tìm sinh viên theo ID
        $student = Student::find($id);
        
        // Lấy tất cả dữ liệu từ request
        $input = $request->all();
        
        // Cập nhật thông tin sinh viên
        $student->update($input);
        
        // Chuyển hướng về trang danh sách sinh viên với thông báo thành công
        return redirect('students')->with('flash_message', 'Student Updated!');  
    }

    /**
     * Xóa sinh viên khỏi cơ sở dữ liệu
     * 
     * @param string $id ID của sinh viên
     * @return \Illuminate\Http\RedirectResponse Chuyển hướng về trang danh sách sinh viên
     */
    public function destroy(string $id): RedirectResponse
    {
        // Xóa sinh viên theo ID
        Student::destroy($id);
        
        // Chuyển hướng về trang danh sách sinh viên với thông báo thành công
        return redirect('students')->with('flash_message', 'Student deleted!'); 
    }
}