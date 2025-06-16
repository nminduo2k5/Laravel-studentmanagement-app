@extends('layout')
@section('content')
 
<div class="card">
  <div class="card-header">Edit Enrollment</div>
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
      
      <form action="{{ url('enrollments/' . $enrollment->id) }}" method="post">
        {!! csrf_field() !!}
        @method("PATCH")
        <input type="hidden" name="id" id="id" value="{{$enrollment->id}}" />
        
        <div class="form-group mb-3">
          <label>Enrollment Number</label>
          <input type="text" name="enroll_no" id="enroll_no" class="form-control" value="{{ old('enroll_no', $enrollment->enroll_no) }}">
        </div>
        
        <div class="form-group mb-3">
          <label>Student</label>
          <select name="student_id" id="student_id" class="form-control">
            <option value="">Select Student</option>
            @foreach($students as $id => $name)
              <option value="{{ $id }}" {{ old('student_id', $enrollment->student_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
          </select>
        </div>
        
        <div class="form-group mb-3">
          <label>Batch</label>
          <select name="batch_id" id="batch_id" class="form-control">
            <option value="">Select Batch</option>
            @foreach($batches as $id => $name)
              <option value="{{ $id }}" {{ old('batch_id', $enrollment->batch_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
          </select>
        </div>
        
        <div class="form-group mb-3">
          <label>Join Date</label>
          <input type="date" name="join_date" id="join_date" class="form-control" value="{{ old('join_date', $enrollment->join_date) }}">
        </div>
        
        <div class="form-group mb-3">
          <label>Fees</label>
          <input type="number" name="fees" id="fees" class="form-control" step="0.01" value="{{ old('fees', $enrollment->fees) }}">
        </div>
        
        <div class="card mb-4 border-info">
          <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="bi bi-calculator me-2"></i>Nhập điểm</h5>
          </div>
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="midterm_grade" class="form-label">Điểm giữa kỳ (30%)</label>
                  <input type="number" name="midterm_grade" id="midterm_grade" class="form-control @error('midterm_grade') is-invalid @enderror" 
                         value="{{ old('midterm_grade', $enrollment->midterm_grade) }}" step="0.1" min="0" max="10">
                  @error('midterm_grade')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              
              <div class="col-md-4">
                <div class="form-group">
                  <label for="final_grade" class="form-label">Điểm cuối kỳ (50%)</label>
                  <input type="number" name="final_grade" id="final_grade" class="form-control @error('final_grade') is-invalid @enderror" 
                         value="{{ old('final_grade', $enrollment->final_grade) }}" step="0.1" min="0" max="10">
                  @error('final_grade')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              
              <div class="col-md-4">
                <div class="form-group">
                  <label for="assignment_grade" class="form-label">Điểm bài tập (20%)</label>
                  <input type="number" name="assignment_grade" id="assignment_grade" class="form-control @error('assignment_grade') is-invalid @enderror" 
                         value="{{ old('assignment_grade', $enrollment->assignment_grade) }}" step="0.1" min="0" max="10">
                  @error('assignment_grade')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
            
            <div class="alert alert-light border">
              <div class="row">
                <div class="col-md-6">
                  <h6 class="card-title">Thang điểm đánh giá</h6>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center p-2">
                      Xuất sắc
                      <span class="badge bg-success rounded-pill">8.5 - 10</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-2">
                      Giỏi
                      <span class="badge bg-primary rounded-pill">7.0 - 8.4</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-2">
                      Khá
                      <span class="badge bg-info rounded-pill">5.5 - 6.9</span>
                    </li>
                  </ul>
                </div>
                <div class="col-md-6">
                  <h6 class="card-title">&nbsp;</h6>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center p-2">
                      Trung bình
                      <span class="badge bg-warning rounded-pill">4.0 - 5.4</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-2">
                      Không đạt
                      <span class="badge bg-danger rounded-pill">0 - 3.9</span>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            
            @if($enrollment->total_grade)
            <div class="alert alert-info mt-3">
              <div class="d-flex justify-content-between align-items-center">
                <span>
                  <strong>Điểm tổng kết hiện tại:</strong> {{ number_format($enrollment->total_grade, 2) }}
                  <span class="badge bg-{{ $enrollment->total_grade >= 8.5 ? 'success' : ($enrollment->total_grade >= 7.0 ? 'primary' : ($enrollment->total_grade >= 5.5 ? 'info' : ($enrollment->total_grade >= 4.0 ? 'warning' : 'danger'))) }} ms-2">
                    {{ $enrollment->getGradeStatus() }}
                  </span>
                </span>
                <small class="text-muted">Điểm sẽ được tính lại khi cập nhật</small>
              </div>
            </div>
            @endif
            
            <div class="form-group mt-3">
              <label for="grade_remarks" class="form-label">Nhận xét của giáo viên</label>
              <textarea name="grade_remarks" id="grade_remarks" class="form-control @error('grade_remarks') is-invalid @enderror" 
                        rows="4" placeholder="Nhập nhận xét về quá trình học tập và kết quả của sinh viên...">{{ old('grade_remarks', $enrollment->grade_remarks) }}</textarea>
              @error('grade_remarks')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>
        
        <input type="submit" value="Update" class="btn btn-success">
      </form>
   
  </div>
</div>
 
@stop