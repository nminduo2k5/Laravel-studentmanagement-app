# BÁO CÁO DỰ ÁN: HỆ THỐNG QUẢN LÝ SINH VIÊN

## 1. TỔNG QUAN DỰ ÁN

Hệ thống Quản lý Sinh viên là một ứng dụng web được phát triển bằng Laravel, giúp quản lý thông tin sinh viên, giáo viên, khóa học, lớp học, đăng ký và thanh toán học phí. Hệ thống được xây dựng theo mô hình MVC (Model-View-Controller) để đảm bảo tính tổ chức, bảo trì và mở rộng.

## 2. KIẾN TRÚC MVC

### 2.1. Model (Mô hình)

Models đại diện cho cấu trúc dữ liệu và logic nghiệp vụ của ứng dụng:

- **Student**: Quản lý thông tin sinh viên (tên, địa chỉ, số điện thoại)
- **Teacher**: Quản lý thông tin giáo viên (tên, địa chỉ, số điện thoại)
- **Course**: Quản lý thông tin khóa học (tên, giáo trình, thời lượng)
- **Batch**: Quản lý thông tin lớp học (tên, khóa học liên kết, ngày bắt đầu)
- **Enrollment**: Quản lý đăng ký học (mã đăng ký, lớp học, sinh viên, ngày tham gia, học phí)
- **Payment**: Quản lý thanh toán học phí (đăng ký liên kết, ngày thanh toán, số tiền)

Các mối quan hệ:
- Batch thuộc về Course (belongsTo)
- Enrollment thuộc về Student và Batch (belongsTo)
- Payment thuộc về Enrollment (belongsTo)

### 2.2. View (Giao diện)

Views hiển thị dữ liệu cho người dùng và thu thập dữ liệu đầu vào:

- **Layout**: Giao diện chung cho toàn bộ ứng dụng
- **Dashboard**: Hiển thị tổng quan về hệ thống (số lượng sinh viên, giáo viên, khóa học, doanh thu...)
- **CRUD Views**: Các giao diện tạo, đọc, cập nhật, xóa cho mỗi đối tượng (students, teachers, courses, batches, enrollments, payments)
- **Authentication Views**: Giao diện đăng nhập, đăng ký

### 2.3. Controller (Điều khiển)

Controllers xử lý các yêu cầu từ người dùng, tương tác với Models và trả về Views:

- **StudentController**: Quản lý các thao tác CRUD với sinh viên
- **TeacherController**: Quản lý các thao tác CRUD với giáo viên
- **CourseController**: Quản lý các thao tác CRUD với khóa học
- **BatchController**: Quản lý các thao tác CRUD với lớp học
- **EnrollmentController**: Quản lý các thao tác CRUD với đăng ký học
- **PaymentController**: Quản lý các thao tác CRUD với thanh toán
- **DashboardController**: Hiển thị thông tin tổng quan
- **AuthController**: Xử lý đăng nhập, đăng ký, đăng xuất

## 3. LUỒNG DỮ LIỆU

1. **Yêu cầu từ người dùng**: Người dùng tương tác với giao diện (View)
2. **Định tuyến (Routes)**: Xác định Controller và phương thức xử lý
3. **Controller xử lý yêu cầu**: Tương tác với Model để truy xuất/cập nhật dữ liệu
4. **Model tương tác với cơ sở dữ liệu**: Thực hiện các thao tác CRUD
5. **Controller trả về View**: Hiển thị kết quả cho người dùng

## 4. CƠ SỞ DỮ LIỆU

### 4.1. Cấu trúc bảng

- **students**: id, name, address, mobile
- **teachers**: id, name, address, mobile
- **courses**: id, name, syllabus, duration
- **batches**: id, name, course_id, start_date
- **enrollments**: id, enroll_no, batch_id, student_id, join_date, fees
- **payments**: id, enroll_no, enrollment_id, payment_date, amount

### 4.2. Mối quan hệ

- **Batch - Course**: Nhiều-một (N-1)
- **Enrollment - Student**: Nhiều-một (N-1)
- **Enrollment - Batch**: Nhiều-một (N-1)
- **Payment - Enrollment**: Nhiều-một (N-1)

## 5. TÍNH NĂNG CHÍNH

1. **Quản lý sinh viên**: Thêm, xem, sửa, xóa thông tin sinh viên
2. **Quản lý giáo viên**: Thêm, xem, sửa, xóa thông tin giáo viên
3. **Quản lý khóa học**: Thêm, xem, sửa, xóa thông tin khóa học
4. **Quản lý lớp học**: Thêm, xem, sửa, xóa thông tin lớp học
5. **Quản lý đăng ký học**: Đăng ký sinh viên vào lớp học
6. **Quản lý thanh toán**: Ghi nhận và theo dõi thanh toán học phí
7. **Bảng điều khiển**: Hiển thị thông tin tổng quan về hệ thống
8. **Xác thực người dùng**: Đăng ký, đăng nhập, đăng xuất

## 6. CÔNG NGHỆ SỬ DỤNG

- **Framework**: Laravel (PHP)
- **Cơ sở dữ liệu**: SQLite/MySQL
- **Frontend**: Blade Templates, Bootstrap, JavaScript, Chart.js
- **Xác thực**: Laravel Authentication

## 7. KẾT LUẬN

Hệ thống Quản lý Sinh viên được xây dựng theo mô hình MVC giúp tách biệt rõ ràng giữa dữ liệu, giao diện và logic xử lý. Điều này mang lại nhiều lợi ích:

- **Tổ chức code rõ ràng**: Dễ dàng phát triển và bảo trì
- **Tái sử dụng code**: Components có thể được tái sử dụng ở nhiều nơi
- **Bảo mật**: Tách biệt logic xử lý và hiển thị giúp tăng cường bảo mật
- **Mở rộng**: Dễ dàng thêm tính năng mới mà không ảnh hưởng đến các phần khác

Hệ thống đáp ứng đầy đủ các yêu cầu quản lý sinh viên, giáo viên, khóa học và thanh toán, cung cấp giao diện trực quan và dễ sử dụng cho người dùng.