@extends('layout')
@section('content')
 
<div class="card">
  <div class="card-header">
    <h4>Thêm giáo viên mới</h4>
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
      
    <form action="{{ url('teachers') }}" method="post">
      {!! csrf_field() !!}
      
      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label for="name" class="form-label">Họ và tên</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required>
          </div>
          
          
          <div class="mb-3">
            <label for="mobile" class="form-label">Số điện thoại</label>
            <input type="text" name="mobile" id="mobile" value="{{ old('mobile') }}" class="form-control" required>
          </div>
          
          <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ</label>
            <textarea name="address" id="address" class="form-control" rows="3">{{ old('address') }}</textarea>
          </div>
        </div>
        
        <div class="col-md-6">
          <div class="mb-3">
            <label for="specialization" class="form-label">Chuyên môn</label>
            <input type="text" name="specialization" id="specialization" value="{{ old('specialization') }}" class="form-control">
          </div>
          
          <div class="mb-3">
            <label for="qualification" class="form-label">Bằng cấp</label>
            <input type="text" name="qualification" id="qualification" value="{{ old('qualification') }}" class="form-control">
          </div>
          
          <div class="mb-3">
            <label for="experience" class="form-label">Số năm kinh nghiệm</label>
            <input type="number" name="experience" id="experience" value="{{ old('experience') }}" class="form-control">
          </div>
          
          <div class="mb-3">
            <label for="join_date" class="form-label">Ngày bắt đầu</label>
            <input type="date" name="join_date" id="join_date" value="{{ old('join_date', date('Y-m-d')) }}" class="form-control">
          </div>
        </div>
      </div>
      
      <div class="d-flex gap-2 mt-3">
        <a href="{{ url('/teachers') }}" class="btn btn-secondary">
          <i class="bi bi-arrow-left"></i> Quay lại
        </a>
        <button type="submit" class="btn btn-success">
          <i class="bi bi-save"></i> Lưu
        </button>
      </div>
    </form>
  </div>
</div>
 
@stop