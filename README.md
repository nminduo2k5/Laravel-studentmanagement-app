# Laravel-studentmanagement-app

## Giới thiệu chung

Đây là một ứng dụng Quản lý Sinh viên (Student Management System) được xây dựng trên nền tảng Laravel, tuân theo mô hình kiến trúc MVC (Model-View-Controller). Ứng dụng cho phép quản lý các thông tin liên quan đến sinh viên, giáo viên, khóa học, lớp học, và các hoạt động liên quan.

## Các chức năng chính

*   Quản lý Sinh viên (CRUD: Thêm, Xem, Sửa, Xóa)
*   Quản lý Giáo viên (CRUD)
*   Quản lý Khóa học (CRUD)
*   Quản lý Lớp học (CRUD)
*   Quản lý Đăng ký học (CRUD)
*   Quản lý Thanh toán (CRUD)
*   Dashboard hiển thị thông tin tổng quan và thống kê.
*   Giao diện người dùng hiện đại và responsive.

## Kiến trúc MVC

Ứng dụng được xây dựng theo mô hình MVC, giúp tách biệt logic nghiệp vụ, dữ liệu và giao diện người dùng:

*   **Models**: Định nghĩa cấu trúc dữ liệu và các mối quan hệ giữa các bảng trong cơ sở dữ liệu.
    *   `Student.php`: Quản lý thông tin sinh viên (tên, địa chỉ, số điện thoại).
    *   Có thể có các model khác như `Teacher`, `Course`, `Batch`, `Enrollment`, `Payment` để quản lý các đối tượng tương ứng.
*   **Views**: Chịu trách nhiệm hiển thị dữ liệu và giao diện người dùng.
    *   `layout.blade.php`: Template chính của ứng dụng, bao gồm các thành phần chung như sidebar, navbar.
    *   Các view con cho từng chức năng cụ thể (ví dụ: danh sách sinh viên, form thêm khóa học,...).
*   **Controllers**: Xử lý logic nghiệp vụ của ứng dụng.
    *   Nhận yêu cầu (request) từ người dùng.
    *   Tương tác với Models để truy vấn hoặc lưu trữ dữ liệu.
    *   Trả về Views phù hợp để hiển thị cho người dùng.
*   **Routes**: Định nghĩa các URL của ứng dụng và liên kết chúng với các phương thức xử lý trong Controllers.
*   **Migrations**: Định nghĩa và quản lý cấu trúc của cơ sở dữ liệu (tạo bảng, sửa đổi cột,...).

## Luồng hoạt động của Dashboard

Dashboard là trang tổng quan của hệ thống, cung cấp cái nhìn nhanh về các số liệu quan trọng. Hoạt động của Dashboard tuân theo mô hình MVC:

### 1. Hiển thị Dashboard (Trang chủ)

*   **URL**: `/` hoặc `/dashboard`
*   **Route**: `Route::get('/', [DashboardController::class, 'index'])->name('dashboard');`
*   **Controller**: `DashboardController@index`
*   **View**: `dashboard.index`
*   **Luồng hoạt động**:
    1.  Người dùng truy cập URL `/` hoặc `/dashboard`.
    2.  Route sẽ điều hướng request đến phương thức `index()` của `DashboardController`.
    3.  Controller truy vấn dữ liệu thống kê cần thiết (ví dụ: số lượng sinh viên, giáo viên, khóa học).
    4.  Controller trả về view `dashboard.index` cùng với dữ liệu thống kê đã lấy được.
    5.  View `dashboard.index` hiển thị các thẻ thông tin, biểu đồ, và các hoạt động gần đây.

### 2. Quản lý Widget trên Dashboard

Hệ thống cho phép quản lý các widget hiển thị trên dashboard.

*(Lưu ý: Hiện tại, chức năng quản lý widget đang sử dụng dữ liệu mẫu. Để triển khai đầy đủ, cần tạo Model `Widget` và migration tương ứng cho cơ sở dữ liệu.)*

#### 2.1. Xem danh sách Widget

*   **URL**: `/dashboard` (Thường là trang chính của dashboard nơi các widget được hiển thị)
*   **Controller**: `DashboardController@index` (Phương thức này cũng có thể chịu trách nhiệm tải dữ liệu cho các widget)
*   **View**: `dashboard.index`

#### 2.2. Xem chi tiết Widget (Ví dụ, nếu mỗi widget có trang chi tiết riêng)

*   **URL**: `/dashboard/{id}` (Trong đó `{id}` là ID của widget)
*   **Route**: `Route::resource('/dashboard', DashboardController::class);` (Route này sẽ tự động tạo ra các route cho CRUD, bao gồm `show`)
*   **Controller**: `DashboardController@show`
*   **View**: `dashboard.show`
*   **Luồng hoạt động**:
    1.  Người dùng truy cập URL `/dashboard/{id}`.
    2.  Route điều hướng request đến phương thức `show($id)` của `DashboardController`.
    3.  Controller lấy thông tin widget dựa trên `$id` (hiện đang dùng dữ liệu mẫu).
    4.  Controller trả về view `dashboard.show` kèm dữ liệu của widget.
    5.  View hiển thị chi tiết widget, có thể bao gồm các nút "Chỉnh sửa" và "Xóa".

#### 2.3. Thêm Widget mới

*   **URL**: `/dashboard/create`
*   **Controller**: `DashboardController@create` (hiển thị form) và `DashboardController@store` (xử lý lưu dữ liệu)
*   **View**: `dashboard.create`
*   **Luồng hoạt động**:
    1.  Người dùng truy cập URL `/dashboard/create`.
    2.  Controller (`create` method) trả về view `dashboard.create` chứa form để thêm widget.
    3.  Người dùng điền thông tin vào form và nhấn gửi.
    4.  Request (thường là POST) được gửi đến URL xử lý (ví dụ: `/dashboard`), Route điều hướng đến phương thức `store()` của `DashboardController`.
    5.  Controller (`store` method) xác thực dữ liệu đầu vào và lưu widget mới (hiện đang mô phỏng việc lưu).
    6.  Controller chuyển hướng người dùng về trang dashboard (hoặc danh sách widget) kèm theo thông báo thành công.

#### 2.4. Chỉnh sửa Widget

*   **URL**: `/dashboard/{id}/edit`
*   **Controller**: `DashboardController@edit` (hiển thị form) và `DashboardController@update` (xử lý cập nhật)
*   **View**: `dashboard.edit`
*   **Luồng hoạt động**:
    1.  Người dùng truy cập URL `/dashboard/{id}/edit` (hoặc nhấn nút "Chỉnh sửa" từ trang chi tiết/danh sách widget).
    2.  Controller (`edit` method) lấy thông tin widget theo `$id` và trả về view `dashboard.edit` với form đã điền sẵn thông tin.
    3.  Người dùng chỉnh sửa thông tin và nhấn gửi.
    4.  Request (thường là PUT/PATCH) được gửi đến URL xử lý (ví dụ: `/dashboard/{id}`), Route điều hướng đến phương thức `update()` của `DashboardController`.
    5.  Controller (`update` method) xác thực dữ liệu và cập nhật thông tin widget (hiện đang mô phỏng việc cập nhật).
    6.  Controller chuyển hướng người dùng về trang dashboard (hoặc trang chi tiết widget) kèm theo thông báo thành công.

#### 2.5. Xóa Widget

*   **URL**: `/dashboard/{id}` (với phương thức HTTP là DELETE)
*   **Controller**: `DashboardController@destroy`
*   **Luồng hoạt động**:
    1.  Người dùng nhấn nút "Xóa" từ trang chi tiết widget hoặc danh sách và xác nhận hành động.
    2.  Request (DELETE) được gửi đến URL `/dashboard/{id}`, Route điều hướng đến phương thức `destroy()` của `DashboardController`.
    3.  Controller (`destroy` method) xóa widget dựa trên `$id` (hiện đang mô phỏng việc xóa).
    4.  Controller chuyển hướng người dùng về trang dashboard (hoặc danh sách widget) kèm theo thông báo thành công.

## Lưu ý quan trọng

Hiện tại, một số chức năng (đặc biệt là quản lý Widget trên Dashboard) đang sử dụng dữ liệu mẫu thay vì dữ liệu thực từ cơ sở dữ liệu. Để triển khai đầy đủ, bạn cần:

1.  Tạo Model `Widget` (nếu chưa có).
2.  Tạo migration tương ứng để định nghĩa bảng `widgets` trong cơ sở dữ liệu.
3.  Cập nhật các phương thức trong `DashboardController` để tương tác với Model `Widget` và cơ sở dữ liệu thực.

## Cài đặt và Chạy dự án (Ví dụ)

*(Phần này cần được cập nhật chi tiết tùy theo dự án của bạn)*

1.  **Clone repository:**
    ```bash
    git clone <your-repository-url>
    cd Laravel-studentmanagement-app
    ```
2.  **Cài đặt dependencies:**
    ```bash
    composer install
    npm install
    npm run dev # hoặc npm run build
    ```
3.  **Cấu hình môi trường:**
    *   Sao chép file `.env.example` thành `.env`: `cp .env.example .env`
    *   Cấu hình thông tin kết nối cơ sở dữ liệu trong file `.env` (DB_DATABASE, DB_USERNAME, DB_PASSWORD, ...).
    *   Tạo key cho ứng dụng: `php artisan key:generate`
4.  **Chạy migrations:**
    ```bash
    php artisan migrate
    ```
5.  **(Tùy chọn) Seed database (nếu có):**
    ```bash
    php artisan db:seed
    ```
6.  **Chạy server:**
    ```bash
    php artisan serve
    ```
    Truy cập ứng dụng tại `http://localhost:8000` (hoặc port được chỉ định).