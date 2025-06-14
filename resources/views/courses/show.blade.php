@extends('layout')
@section('content')

<div class="card">
  <div class="card-header">
    <h4>Chi tiết khóa học</h4>
  </div>
  <div class="card-body">
    <div class="row mb-4">
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Thông tin khóa học</h5>
          </div>
          <div class="card-body">
            <h4 class="mb-3">{{ $course->name }}</h4>
            <p><strong><i class="bi bi-book me-2"></i>Nội dung:</strong> {{ $course->syllabus }}</p>
            <p><strong><i class="bi bi-clock me-2"></i>Thời lượng:</strong> {{ $course->duration() }}</p>
          </div>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-header bg-info text-white">
            <h5 class="mb-0">Thống kê</h5>
          </div>
          <div class="card-body">
            <div class="row text-center">
              <div class="col-4 mb-3">
                <div class="p-3 border rounded">
                  <h3 class="text-primary mb-1">{{ $course->batches->count() }}</h3>
                  <p class="text-muted mb-0">Lớp học</p>
                </div>
              </div>
              <div class="col-4 mb-3">
                <div class="p-3 border rounded">
                  <h3 class="text-success mb-1">{{ $course->teachers->count() }}</h3>
                  <p class="text-muted mb-0">Giáo viên</p>
                </div>
              </div>
              <div class="col-4 mb-3">
                <div class="p-3 border rounded">
                  <h3 class="text-info mb-1">{{ $course->batches->sum(function($batch) { return $batch->enrollments->count(); }) }}</h3>
                  <p class="text-muted mb-0">Sinh viên</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="card mb-4">
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Giáo viên giảng dạy</h5>
        <a href="{{ route('courses.assign.teachers.form', $course->id) }}" class="btn btn-sm btn-light">
          <i class="bi bi-person-plus"></i> Phân công giáo viên
        </a>
      </div>
      <div class="card-body">
        @if($course->teachers->count() > 0)
        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Tên giáo viên</th>
                <th>Chuyên môn</th>
                <th>Vai trò</th>
                <th>Giáo viên chính</th>
                <th>Thao tác</th>
              </tr>
            </thead>
            <tbody>
              @foreach($course->teachers as $teacher)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $teacher->name }}</td>
                <td>{{ $teacher->specialization ?? 'N/A' }}</td>
                <td>{{ $teacher->pivot->role ?? 'N/A' }}</td>
                <td>
                  @if($teacher->pivot->is_primary)
                    <span class="badge bg-success">Giáo viên chính</span>
                  @else
                    <span class="badge bg-secondary">Giáo viên phụ</span>
                  @endif
                </td>
                <td>
                  <a href="{{ url('/teachers/' . $teacher->id) }}" class="btn btn-sm btn-info">
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
          Chưa có giáo viên nào được phân công cho khóa học này.
        </div>
        @endif
      </div>
    </div>
    
    @if($course->batches && $course->batches->count() > 0)
    <div class="card mb-4">
      <div class="card-header bg-success text-white">
        <h5 class="mb-0">Danh sách lớp học</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Tên lớp</th>
                <th>Ngày bắt đầu</th>
                <th>Số sinh viên</th>
                <th>Thao tác</th>
              </tr>
            </thead>
            <tbody>
              @foreach($course->batches as $batch)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $batch->name }}</td>
                <td>{{ date('d-m-Y', strtotime($batch->start_date)) }}</td>
                <td>{{ $batch->enrollments->count() }}</td>
                <td>
                  <a href="{{ url('/batches/' . $batch->id) }}" class="btn btn-sm btn-info">
                    <i class="bi bi-eye"></i> Chi tiết
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    @endif
    
    <div class="d-flex gap-2">
      <a href="{{ url('/courses') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Quay lại
      </a>
      <a href="{{ url('/courses/' . $course->id . '/edit') }}" class="btn btn-primary">
        <i class="bi bi-pencil-square"></i> Chỉnh sửa
      </a>
      <a href="{{ url('/batches/create?course_id=' . $course->id) }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Thêm lớp học
      </a>
      <a href="{{ route('courses.assign.teachers.form', $course->id) }}" class="btn btn-info">
        <i class="bi bi-person-plus"></i> Phân công giáo viên
      </a>
    </div>
  </div>
</div>

@endsection