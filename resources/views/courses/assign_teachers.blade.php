@extends('layout')
@section('content')

<div class="card">
  <div class="card-header">
    <h4>Gán giáo viên cho khóa học: {{ $course->name }}</h4>
  </div>
  <div class="card-body">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <form action="{{ route('courses.assign.teachers', $course->id) }}" method="post">
      @csrf
      
      <div class="mb-4">
        <h5>Thông tin khóa học</h5>
        <p><strong>Tên khóa học:</strong> {{ $course->name }}</p>
        <p><strong>Nội dung:</strong> {{ $course->syllabus }}</p>
        <p><strong>Thời lượng:</strong> {{ $course->duration() }}</p>
      </div>
      
      <div class="mb-4">
        <h5>Chọn giáo viên</h5>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead class="table-light">
              <tr>
                <th>Chọn</th>
                <th>Giáo viên chính</th>
                <th>Tên giáo viên</th>
                <th>Chuyên môn</th>
                <th>Vai trò trong khóa học</th>
              </tr>
            </thead>
            <tbody>
              @foreach($teachers as $teacher)
              <tr>
                <td class="text-center">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="teacher_ids[]" value="{{ $teacher->id }}" id="teacher{{ $teacher->id }}" 
                      {{ in_array($teacher->id, $assignedTeachers) ? 'checked' : '' }}>
                  </div>
                </td>
                <td class="text-center">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="primary_teacher_id" value="{{ $teacher->id }}" id="primary{{ $teacher->id }}"
                      {{ $primaryTeacher && $primaryTeacher->id == $teacher->id ? 'checked' : '' }}>
                  </div>
                </td>
                <td>{{ $teacher->name }}</td>
                <td>{{ $teacher->specialization ?? 'N/A' }}</td>
                <td>
                  <select name="roles[{{ $teacher->id }}]" class="form-control">
                    <option value="">Chọn vai trò</option>
                    <option value="Giảng viên chính" {{ $course->teachers->where('id', $teacher->id)->first() && $course->teachers->where('id', $teacher->id)->first()->pivot->role == 'Giảng viên chính' ? 'selected' : '' }}>Giảng viên chính</option>
                    <option value="Giảng viên phụ" {{ $course->teachers->where('id', $teacher->id)->first() && $course->teachers->where('id', $teacher->id)->first()->pivot->role == 'Giảng viên phụ' ? 'selected' : '' }}>Giảng viên phụ</option>
                    <option value="Trợ giảng" {{ $course->teachers->where('id', $teacher->id)->first() && $course->teachers->where('id', $teacher->id)->first()->pivot->role == 'Trợ giảng' ? 'selected' : '' }}>Trợ giảng</option>
                  </select>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      
      <div class="d-flex gap-2">
        <a href="{{ url('/courses/' . $course->id) }}" class="btn btn-secondary">
          <i class="bi bi-arrow-left"></i> Quay lại
        </a>
        <button type="submit" class="btn btn-primary">
          <i class="bi bi-save"></i> Lưu thay đổi
        </button>
      </div>
    </form>
  </div>
</div>

@endsection