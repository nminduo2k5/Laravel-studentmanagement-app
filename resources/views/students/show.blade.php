@extends('layout')
@section('content')

<div class="card">
  <div class="card-header">
    <h4>Thông tin chi tiết sinh viên</h4>
  </div>
  <div class="card-body">
    <div class="row mb-4">
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Thông tin cá nhân</h5>
          </div>
          <div class="card-body">
            <div class="d-flex mb-3">
              <div class="avatar-placeholder bg-light rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                <i class="bi bi-person-circle fs-1"></i>
              </div>
              <div>
                <h4 class="mb-1">{{ $students->name }}</h4>
                <p class="text-muted mb-0">Mã sinh viên: {{ $students->id }}</p>
              </div>
            </div>
            <div class="mb-3">
             
              <p><strong><i class="bi bi-telephone me-2"></i>Số điện thoại:</strong> {{ $students->mobile }}</p>
              <p><strong><i class="bi bi-geo-alt me-2"></i>Địa chỉ:</strong> {{ $students->address }}</p>
              <p><strong><i class="bi bi-award me-2"></i>Điểm GPA:</strong> <span class="badge bg-success">{{ $students->gpa ?? 'N/A' }}</span></p>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-header bg-info text-white">
            <h5 class="mb-0">Thống kê học tập</h5>
          </div>
          <div class="card-body">
            <div class="row text-center">
              <div class="col-4 mb-3">
                <div class="p-3 border rounded">
                  <h3 class="text-primary mb-1">{{ $students->enrollments->count() ?? 0 }}</h3>
                  <p class="text-muted mb-0">Khóa học</p>
                </div>
              </div>
              <div class="col-4 mb-3">
                <div class="p-3 border rounded">
                  <h3 class="text-success mb-1">{{ $students->payments->count() ?? 0 }}</h3>
                  <p class="text-muted mb-0">Thanh toán</p>
                </div>
              </div>
              <div class="col-4 mb-3">
                <div class="p-3 border rounded">
                  <h3 class="text-info mb-1">{{ $students->gpa ?? '0.0' }}</h3>
                  <p class="text-muted mb-0">GPA</p>
                </div>
              </div>
            </div>
            
            <div class="mt-3">
              <h6 class="mb-3">Tổng quan học tập</h6>
              <div class="progress mb-2" style="height: 10px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: {{ ($students->gpa ?? 0) * 25 }}%" aria-valuenow="{{ $students->gpa ?? 0 }}" aria-valuemin="0" aria-valuemax="4"></div>
              </div>
              <small class="text-muted">Điểm GPA: {{ $students->gpa ?? '0.0' }}/4.0</small>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    @if($students->enrollments && $students->enrollments->count() > 0)
    <div class="card mb-4">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Danh sách khóa học đã đăng ký</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Mã đăng ký</th>
                <th>Khóa học</th>
                <th>Lớp</th>
                <th>Ngày đăng ký</th>
                <th>Học phí</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
              </tr>
            </thead>
            <tbody>
              @foreach($students->enrollments as $enrollment)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $enrollment->enroll_no }}</td>
                <td>{{ $enrollment->batch && $enrollment->batch->course ? $enrollment->batch->course->name : 'N/A' }}</td>
                <td>{{ $enrollment->batch ? $enrollment->batch->name : 'N/A' }}</td>
                <td>{{ date('d-m-Y', strtotime($enrollment->join_date)) }}</td>
                <td>{{ number_format($enrollment->fees, 0, ',', '.') }} đ</td>
                <td>
                  @php
                    $totalPaid = $enrollment->payments ? $enrollment->payments->sum('amount') : 0;
                    $percentPaid = $enrollment->fees > 0 ? ($totalPaid / $enrollment->fees) * 100 : 0;
                  @endphp
                  
                  @if($percentPaid >= 100)
                    <span class="badge bg-success">Đã thanh toán</span>
                  @elseif($percentPaid > 0)
                    <span class="badge bg-warning">Đã thanh toán một phần</span>
                  @else
                    <span class="badge bg-danger">Chưa thanh toán</span>
                  @endif
                </td>
                <td>
                  <a href="{{ url('/enrollments/' . $enrollment->id) }}" class="btn btn-sm btn-info">
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
    
    @if($students->payments && $students->payments->count() > 0)
    <div class="card mb-4">
      <div class="card-header bg-success text-white">
        <h5 class="mb-0">Lịch sử thanh toán</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Mã đăng ký</th>
                <th>Ngày thanh toán</th>
                <th>Số tiền</th>
                <th>Thao tác</th>
              </tr>
            </thead>
            <tbody>
              @foreach($students->payments as $payment)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $payment->enrollment ? $payment->enrollment->enroll_no : 'N/A' }}</td>
                <td>{{ date('d-m-Y', strtotime($payment->payment_date)) }}</td>
                <td>{{ number_format($payment->amount, 0, ',', '.') }} đ</td>
                <td>
                  <a href="{{ url('/payments/' . $payment->id) }}" class="btn btn-sm btn-info">
                    <i class="bi bi-eye"></i> Chi tiết
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th colspan="3" class="text-end">Tổng thanh toán:</th>
                <th>{{ number_format($students->payments->sum('amount'), 0, ',', '.') }} đ</th>
                <th></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
    @endif
    
    <div class="d-flex gap-2">
      <a href="{{ url('/students') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Quay lại
      </a>
      <a href="{{ url('/students/' . $students->id . '/edit') }}" class="btn btn-primary">
        <i class="bi bi-pencil-square"></i> Chỉnh sửa
      </a>
      <a href="{{ url('/enrollments/create?student_id=' . $students->id) }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Thêm đăng ký mới
      </a>
    </div>
  </div>
</div>

@endsection