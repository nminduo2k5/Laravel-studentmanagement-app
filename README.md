# Hệ thống Quản lý Sinh viên Laravel

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

## Tác giả
- **Nguyễn Minh Dương** - 23010441
- **Nguyễn Văn Tú** - [Mã sinh viên]

## Giới thiệu

Hệ thống Quản lý Sinh viên là một ứng dụng web được xây dựng trên nền tảng Laravel 12, tuân theo mô hình kiến trúc MVC. Ứng dụng cung cấp giải pháp toàn diện để quản lý sinh viên, giáo viên, khóa học, lớp học, đăng ký và thanh toán học phí với giao diện hiện đại và thân thiện.

## Tính năng chính

### 🎓 Quản lý Sinh viên
- Thêm, xem, sửa, xóa thông tin sinh viên
- Tự động tính toán GPA từ điểm số các môn học
- Theo dõi lịch sử đăng ký và thanh toán
- Quản lý thông tin cá nhân (tên, địa chỉ, số điện thoại)

### 👨‍🏫 Quản lý Giáo viên
- Quản lý thông tin giáo viên (chuyên môn, kinh nghiệm, bằng cấp)
- Phân công giáo viên cho các khóa học
- Theo dõi số lượng lớp học và sinh viên được dạy
- Hỗ trợ nhiều giáo viên cho một khóa học

### 📚 Quản lý Khóa học
- Tạo và quản lý khóa học với nội dung chi tiết
- Phân công giáo viên chính và giáo viên phụ
- Theo dõi doanh thu từ từng khóa học
- Quản lý thời lượng và giáo trình

### 🏫 Quản lý Lớp học (Batches)
- Tạo các lớp học cho từng khóa học
- Quản lý lịch học và ngày bắt đầu
- Theo dõi tỷ lệ thanh toán của lớp
- Thống kê số lượng sinh viên đăng ký

### 📝 Quản lý Đăng ký
- Đăng ký sinh viên vào các lớp học
- Quản lý điểm số (giữa kỳ, cuối kỳ, bài tập)
- Tự động tính điểm tổng kết và xếp loại
- Theo dõi trạng thái học tập

### 💰 Quản lý Thanh toán
- Ghi nhận các khoản thanh toán học phí
- Theo dõi lịch sử thanh toán của sinh viên
- Thống kê doanh thu theo thời gian
- Quản lý công nợ học phí

### 📊 Dashboard & Báo cáo
- Hiển thị thống kê tổng quan hệ thống
- Biểu đồ doanh thu theo tháng
- Theo dõi hoạt động gần đây
- Giao diện trực quan với Bootstrap 5

### 🔐 Xác thực & Bảo mật
- Hệ thống đăng nhập/đăng ký với Laravel Fortify
- Quản lý hồ sơ người dùng
- Bảo vệ các route quan trọng
- Hỗ trợ chế độ sáng/tối

## Công nghệ sử dụng

- **Backend**: PHP 8.2+, Laravel 12.x
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5
- **Database**: MySQL/SQLite
- **Authentication**: Laravel Fortify
- **Icons**: Bootstrap Icons
- **Charts**: Chart.js
- **Fonts**: Google Fonts (Poppins)
- **Animations**: Animate.css

## Cấu trúc cơ sở dữ liệu

### Bảng chính
- `students` - Thông tin sinh viên
- `teachers` - Thông tin giáo viên  
- `courses` - Thông tin khóa học
- `batches` - Thông tin lớp học
- `enrollments` - Đăng ký học
- `payments` - Thanh toán
- `teacher_course` - Quan hệ giáo viên-khóa học
- `users` - Tài khoản người dùng

### Mối quan hệ
- **Teacher ↔ Course**: Many-to-Many (qua bảng teacher_course)
- **Course → Batch**: One-to-Many
- **Student → Enrollment**: One-to-Many  
- **Batch → Enrollment**: One-to-Many
- **Enrollment → Payment**: One-to-Many

## Cài đặt và Triển khai

### Yêu cầu hệ thống
- PHP >= 8.2
- Composer
- MySQL hoặc SQLite
- Node.js & NPM (tùy chọn)

### Các bước cài đặt

1. **Clone repository**
```bash
git clone https://github.com/nminduo2k5/Laravel-studentmanagement-app.git
cd Laravel-studentmanagement-app
```

2. **Cài đặt dependencies**
```bash
composer install
```

3. **Cấu hình môi trường**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Cấu hình database trong .env**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=student_management
DB_USERNAME=root
DB_PASSWORD=
```

5. **Chạy migrations**
```bash
php artisan migrate
```

6. **Khởi động server**
```bash
php artisan serve
```

Truy cập ứng dụng tại: `http://localhost:8000`

## Cấu trúc thư mục

```
├── app/
│   ├── Http/Controllers/          # Controllers xử lý logic
│   ├── Models/                    # Eloquent Models
│   ├── Observers/                 # Event Observers
│   └── Providers/                 # Service Providers
├── database/
│   ├── migrations/                # Database migrations
│   └── seeders/                   # Database seeders
├── resources/
│   ├── views/                     # Blade templates
│   ├── css/                       # Custom CSS
│   └── js/                        # Custom JavaScript
├── routes/
│   └── web.php                    # Web routes
└── public/
    ├── css/                       # Compiled CSS
    ├── js/                        # Compiled JS
    └── img/                       # Images
```

## Tính năng nổi bật

### 🎯 Tính toán GPA tự động
Hệ thống tự động tính toán GPA theo thang điểm 4.0 dựa trên điểm số các môn học:
- 8.5-10: 4.0 (Excellent)
- 7.0-8.4: 3.0 (Good)  
- 5.5-6.9: 2.0 (Fair)
- 4.0-5.4: 1.0 (Average)
- <4.0: 0.0 (Fail)

### 📈 Thống kê và báo cáo
- Dashboard với các thẻ thống kê trực quan
- Biểu đồ doanh thu theo tháng
- Theo dõi hoạt động gần đây
- Tỷ lệ thanh toán học phí

### 🎨 Giao diện hiện đại
- Responsive design với Bootstrap 5
- Dark/Light mode toggle
- Smooth animations với Animate.css
- Toast notifications
- Bootstrap Icons

## API Routes

### Authentication Routes (Laravel Fortify)
- `GET /login` - Trang đăng nhập
- `POST /login` - Xử lý đăng nhập
- `GET /register` - Trang đăng ký
- `POST /register` - Xử lý đăng ký
- `POST /logout` - Đăng xuất

### Resource Routes (yêu cầu đăng nhập)
- `GET /` - Dashboard
- `/students` - CRUD sinh viên
- `/teachers` - CRUD giáo viên
- `/courses` - CRUD khóa học
- `/batches` - CRUD lớp học
- `/enrollments` - CRUD đăng ký
- `/payments` - CRUD thanh toán

### Special Routes
- `GET /courses/{course}/assign-teachers` - Phân công giáo viên
- `GET /enrollments/{enrollment}/grades` - Quản lý điểm số
- `GET /profile` - Hồ sơ cá nhân

## Đóng góp

1. Fork repository
2. Tạo feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Tạo Pull Request

## Giấy phép

Dự án được phân phối dưới giấy phép MIT. Xem file `LICENSE` để biết thêm chi tiết.

## Liên hệ

- **Tác giả**: Nguyễn Minh Dương
- **Email**: 23010441@st.phenikaa-uni.edu.vn
- **GitHub**: [nminduo2k5](https://github.com/nminduo2k5)
- **Trường**: Đại học Phenikaa

## Screenshots

### Dashboard
![Dashboard](img/phenikaa.png)

### Quản lý sinh viên
- Danh sách sinh viên với thông tin GPA
- Form thêm/sửa sinh viên
- Chi tiết sinh viên và lịch sử học tập

### Quản lý điểm số
- Nhập điểm giữa kỳ, cuối kỳ, bài tập
- Tự động tính điểm tổng kết
- Xếp loại học lực

## Lời cảm ơn

- Laravel Team cho framework tuyệt vời
- Bootstrap Team cho thư viện UI components
- Đại học Phenikaa cho môi trường học tập
- Tất cả contributors đã đóng góp cho dự án

---

⭐ **Nếu dự án hữu ích, hãy cho một star để ủng hộ!** ⭐