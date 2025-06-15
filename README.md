# Laravel Student Management System

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>
## Tác giả
Nguyễn Minh Dương -23010441
Nguyễn Văn Tú -
## Giới thiệu

Hệ thống Quản lý Sinh viên được xây dựng trên nền tảng Laravel, tuân theo mô hình kiến trúc MVC (Model-View-Controller). Ứng dụng cung cấp giải pháp toàn diện để quản lý sinh viên, giáo viên, khóa học, lớp học, đăng ký và thanh toán học phí.

## Tính năng chính

- **Quản lý Sinh viên**: Thêm, xem, sửa, xóa thông tin sinh viên (tên, địa chỉ, email, điện thoại, GPA)
- **Quản lý Giáo viên**: Thêm, xem, sửa, xóa thông tin giáo viên (tên, chuyên môn, kinh nghiệm)
- **Quản lý Khóa học**: Tạo và quản lý các khóa học với nội dung, thời lượng và phân công giáo viên
- **Quản lý Lớp học**: Tạo các lớp học cho từng khóa học với lịch học và thời gian bắt đầu
- **Quản lý Đăng ký**: Theo dõi việc đăng ký của sinh viên vào các lớp học
- **Quản lý Thanh toán**: Ghi nhận và theo dõi các khoản thanh toán học phí
- **Dashboard**: Hiển thị thông tin tổng quan và thống kê về sinh viên, giáo viên, khóa học và doanh thu
- **Xác thực và Phân quyền**: Hệ thống đăng nhập/đăng ký và phân quyền người dùng

## Công nghệ sử dụng

- **Backend**: PHP 8.x, Laravel 10.x
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5
- **Database**: MySQL
- **Authentication**: Laravel Breeze
- **Các package khác**: Laravel Eloquent, Blade Template Engine

## Cấu trúc dự án

### Models

- `Student.php`: Quản lý thông tin sinh viên và mối quan hệ với enrollments, payments
- `Teacher.php`: Quản lý thông tin giáo viên và mối quan hệ với courses
- `Course.php`: Quản lý thông tin khóa học và mối quan hệ với teachers, batches
- `Batch.php`: Quản lý thông tin lớp học và mối quan hệ với course, enrollments
- `Enrollment.php`: Quản lý việc đăng ký học và mối quan hệ với student, batch, payments
- `Payment.php`: Quản lý thông tin thanh toán và mối quan hệ với enrollment

### Controllers

- `StudentController.php`: Xử lý các thao tác CRUD cho sinh viên
- `TeacherController.php`: Xử lý các thao tác CRUD cho giáo viên
- `CourseController.php`: Xử lý các thao tác CRUD cho khóa học
- `BatchController.php`: Xử lý các thao tác CRUD cho lớp học
- `EnrollmentController.php`: Xử lý các thao tác CRUD cho đăng ký học
- `PaymentController.php`: Xử lý các thao tác CRUD cho thanh toán
- `DashboardController.php`: Xử lý hiển thị thông tin tổng quan và thống kê
- `AuthController.php`: Xử lý đăng nhập, đăng ký và xác thực người dùng

### Views

- `layout.blade.php`: Template chính của ứng dụng
- `dashboard/`: Chứa các view liên quan đến dashboard
- `students/`: Chứa các view liên quan đến quản lý sinh viên
- `teachers/`: Chứa các view liên quan đến quản lý giáo viên
- `courses/`: Chứa các view liên quan đến quản lý khóa học
- `batches/`: Chứa các view liên quan đến quản lý lớp học
- `enrollments/`: Chứa các view liên quan đến quản lý đăng ký
- `payments/`: Chứa các view liên quan đến quản lý thanh toán
- `auth/`: Chứa các view liên quan đến xác thực

### Routes

- `web.php`: Định nghĩa các route cho ứng dụng web
- `api.php`: Định nghĩa các route cho API (nếu có)

### Migrations

- `create_users_table.php`: Tạo bảng users
- `create_students_table.php`: Tạo bảng students
- `create_teachers_table.php`: Tạo bảng teachers
- `create_courses_table.php`: Tạo bảng courses
- `create_batches_table.php`: Tạo bảng batches
- `create_enrollments_table.php`: Tạo bảng enrollments
- `create_payments_table.php`: Tạo bảng payments
- `create_teacher_course_table.php`: Tạo bảng trung gian cho quan hệ nhiều-nhiều giữa teachers và courses

## Mối quan hệ giữa các bảng

- **Teacher - Course**: Quan hệ nhiều-nhiều (many-to-many) thông qua bảng trung gian `teacher_course`
- **Course - Batch**: Quan hệ một-nhiều (one-to-many), một khóa học có thể có nhiều lớp học
- **Student - Enrollment**: Quan hệ một-nhiều (one-to-many), một sinh viên có thể đăng ký nhiều lớp học
- **Batch - Enrollment**: Quan hệ một-nhiều (one-to-many), một lớp học có thể có nhiều sinh viên đăng ký
- **Enrollment - Payment**: Quan hệ một-nhiều (one-to-many), một đăng ký có thể có nhiều lần thanh toán

## Luồng hoạt động chính

### Quản lý Sinh viên

1. **Xem danh sách sinh viên**:
   - URL: `/students`
   - Controller: `StudentController@index`
   - View: `students.index`

2. **Xem chi tiết sinh viên**:
   - URL: `/students/{id}`
   - Controller: `StudentController@show`
   - View: `students.show`

3. **Thêm sinh viên mới**:
   - URL: `/students/create` (GET), `/students` (POST)
   - Controller: `StudentController@create`, `StudentController@store`
   - View: `students.create`

4. **Chỉnh sửa sinh viên**:
   - URL: `/students/{id}/edit` (GET), `/students/{id}` (PUT/PATCH)
   - Controller: `StudentController@edit`, `StudentController@update`
   - View: `students.edit`

5. **Xóa sinh viên**:
   - URL: `/students/{id}` (DELETE)
   - Controller: `StudentController@destroy`

### Quản lý Giáo viên và Khóa học

1. **Phân công giáo viên cho khóa học**:
   - URL: `/courses/{course}/assign-teachers` (GET), `/courses/{course}/assign-teachers` (POST)
   - Controller: `TeacherCourseController@assignForm`, `TeacherCourseController@assign`
   - View: `courses.assign_teachers`

2. **Xem khóa học của giáo viên**:
   - URL: `/teachers/{teacher}/courses`
   - Controller: `TeacherCourseController@teacherCourses`
   - View: `teachers.courses`

### Dashboard

1. **Hiển thị tổng quan**:
   - URL: `/` hoặc `/dashboard`
   - Controller: `DashboardController@index`
   - View: `dashboard.index`
   - Hiển thị: Số lượng sinh viên, giáo viên, khóa học, lớp học, doanh thu

## Cài đặt và Chạy dự án

### Yêu cầu hệ thống

- PHP >= 8.1
- Composer
- MySQL hoặc MariaDB
- Node.js và NPM (cho việc biên dịch assets)

### Các bước cài đặt

1. **Clone repository:**
   ```bash
   git clone https://github.com/yourusername/Laravel-studentmanagement-app.git
   cd Laravel-studentmanagement-app
   ```

2. **Cài đặt dependencies:**
   ```bash
   composer install
   npm install
   npm run dev # hoặc npm run build
   ```

3. **Cấu hình môi trường:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   
   Chỉnh sửa file `.env` để cấu hình kết nối database:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=student_management
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Chạy migrations và seeders:**
   ```bash
   php artisan migrate
   php artisan db:seed # nếu có seeders
   ```

5. **Chạy server:**
   ```bash
   php artisan serve
   ```
   
   Truy cập ứng dụng tại `http://localhost:8000`

### Tài khoản mặc định (nếu có)

- **Admin**:
  - Email: admin@example.com
  - Password: password

- **User**:
  - Email: user@example.com
  - Password: password

## Đóng góp

Nếu bạn muốn đóng góp cho dự án, vui lòng:

1. Fork repository
2. Tạo branch mới (`git checkout -b feature/amazing-feature`)
3. Commit thay đổi của bạn (`git commit -m 'Add some amazing feature'`)
4. Push lên branch (`git push origin feature/amazing-feature`)
5. Mở Pull Request

## Giấy phép

Dự án này được phân phối dưới giấy phép MIT. Xem file `LICENSE` để biết thêm chi tiết.

## Liên hệ

- **Tác giả**: Nguyễn Minh Dương
- **Email**: 23010441@st.phenikaa-uni.edu.vn
- **GitHub**: [Your GitHub Profile](https://github.com/nminduo2k5)

## Lời cảm ơn

- Laravel Team cho framework tuyệt vời
- Bootstrap Team cho thư viện CSS
- Tất cả những người đóng góp cho dự án