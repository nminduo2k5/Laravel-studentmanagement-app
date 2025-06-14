@extends('layout')
@section('content')
 
<div class="card">
  <div class="card-header">
    <h4>Chỉnh sửa lớp học</h4>
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
      
    <form action="{{ url('batches/' . $batches->id) }}" method="post">
      {!! csrf_field() !!}
      @method("PATCH")
      <input type="hidden" name="id" id="id" value="{{ $batches->id }}" />
      
      <div class="mb-3">
        <label for="name" class="form-label">Tên lớp học</label>
        <input type="text" name="name" id="name" value="{{ $batches->name }}" class="form-control" required>
      </div>
      
      <div class="mb-3">
        <label for="course_id" class="form-label">Khóa học</label>
        <select name="course_id" id="course_id" class="form-control" required>
          <option value="">-- Chọn khóa học --</option>
          @foreach($courses as $id => $name)
            <option value="{{ $id }}" {{ $batches->course_id == $id ? 'selected' : '' }}>{{ $name }}</option>
          @endforeach
        </select>
      </div>
      
      <div class="mb-3">
        <label for="start_date" class="form-label">Ngày bắt đầu</label>
        <input type="date" name="start_date" id="start_date" value="{{ \Carbon\Carbon::parse($batches->start_date)->format('Y-m-d') }}" class="form-control" required>
      </div>
      
      <div class="d-flex gap-2">
        <a href="{{ url('/batches') }}" class="btn btn-secondary">
          <i class="bi bi-arrow-left"></i> Quay lại
        </a>
        <button type="submit" class="btn btn-primary">
          <i class="bi bi-save"></i> Lưu thay đổi
        </button>
      </div>
    </form>
  </div>
</div>
 
@stop