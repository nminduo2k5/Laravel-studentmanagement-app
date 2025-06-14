@extends('layout')
@section('content')

<div class="card">
  <div class="card-header">
    <h4>Khóa học của giáo viên: {{ $teacher->name }}</h4>
  </div>
  <div class="card-body">
    <div class="row mb-4">
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Thông tin giáo viên</h5>
          </div>
          <div class="card-body">
            <div class="d-flex mb-3">
              <div class="avatar-placeholder bg-light rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                <i class="bi bi-person-workspace fs-1"></i>
              </div>
              <div>
                <h4 class="mb-1">{{ $teacher->name }}</h4>
                <p class="text-muted mb-0">Mã giáo viên: {{ $teacher->id }}</p>
              </div>
            </div>
            <div class="mb-3">
             
              <p><strong><i class="bi bi-telephone me-2"></i>Số điện thoại:</strong> {{ $teacher->mobile }}</p>
              <p><strong><i class="bi bi-briefcase me-2"></i>Chuyên môn:</strong> {{ $teacher->specialization ?? 'Chưa cập nhật' }}</p>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-header bg-info text-white">
            <h5 class="mb-0">Thống kê giảng dạy</h5>
          </div>
          <div class="card-body">
            <div class="row text-center">
              <div class="col-4 mb-3">
                <div class="p-3 border rounded">
                  <h3 class="text-primary mb-1">{{ $teacher->courses->count() }}</h3>
                  <p class="text-muted mb-0">Tổng khóa học</p>
                </div>
              </div>
              <div class="col-4 mb-3">
                <div class="p-3 border rounded">
                  <h3 class="text-success mb-1">{{ $teacher->primaryCourses->count() }}</h3>
                  <p class="text-muted mb-0">Khóa học chính</p>
                </div>
              </div>
              <div class="col-4 mb-3">
                <div class="p-3 border rounded">
                  <h3 class="text-info mb-1">{{ $batchCount }}</h3>
                  <p class="text-muted mb-0">Lớp học</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="card mb-4">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Khóa học đang giảng dạy</h5>
      </div>
      <div class="card-body">
        @if($teacher->courses->count() > 0)
        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Tên khóa học</th>
                <th>Thời lượng</th>
                <th>Vai trò</th>
                <th>Giáo viên chính</th>
                <th>Số lớp</th>
                <th>Thao tác</th>
              </tr>
            </thead>
            <tbody>
              @foreach($teacher->courses as $course)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $course->name }}</td>
                <td>{{ $course->duration() }}</td>
                <td>{{ $course->pivot->role ?? 'N/A' }}</td>
                <td>
                  @if($course->pivot->is_primary)
                    <span class="badge bg-success">Giáo viên chính</span>
                  @else
                    <span class="badge bg-secondary">Giáo viên phụ</span>
                  @endif
                </td>
                <td>{{ $course->batches->count() }}</td>
                <td>
                  <a href="{{ url('/courses/' . $course->id) }}" class="btn btn-sm btn-info">
                    <i class="bi bi-eye"></i> Chi tiết
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @else
        <div class="alert alert-info">
          Giáo viên này chưa được phân công giảng dạy khóa học nào.
        </div>
        @endif
      </div>
    </div>
    
    <div class="d-flex gap-2">
      <a href="{{ url('/teachers/' . $teacher->id) }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Quay lại
      </a>
      <a href="{{ url('/courses/create?teacher_id=' . $teacher->id) }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Thêm khóa học mới
      </a>
    </div>
  </div>
</div>

@endsection