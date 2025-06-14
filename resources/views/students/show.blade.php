@extends('layout')
@section('content')

<div class="card">
  <div class="card-header">
    <h4 class="text-nowrap">Student Information</h4>
  </div>
  <div class="card-body">
    <div class="row mb-4">
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0 text-nowrap">Personal Information</h5>
          </div>
          <div class="card-body">
            <div class="d-flex mb-3">
              <div class="avatar-placeholder bg-light rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                <i class="bi bi-person-circle fs-1"></i>
              </div>
              <div>
                <h4 class="mb-1 text-nowrap">{{ $students->name }}</h4>
                <p class="text-muted mb-0 text-nowrap">Student ID: {{ $students->id }}</p>
              </div>
            </div>
            <div class="mb-3">
              <p class="text-nowrap"><strong><i class="bi bi-telephone me-2"></i>Phone:</strong> {{ $students->mobile }}</p>
              <p class="text-nowrap"><strong><i class="bi bi-geo-alt me-2"></i>Address:</strong> {{ $students->address }}</p>
              <p class="text-nowrap"><strong><i class="bi bi-award me-2"></i>GPA:</strong> <span class="badge bg-success text-nowrap">{{ $students->gpa ?? 'N/A' }}</span></p>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-header bg-info text-white">
            <h5 class="mb-0 text-nowrap">Academic Statistics</h5>
          </div>
          <div class="card-body">
            <div class="row text-center">
              <div class="col-4 mb-3">
                <div class="p-3 border rounded text-nowrap">
                  <h3 class="text-primary mb-1">{{ $students->enrollments->count() ?? 0 }}</h3>
                  <p class="text-muted mb-0">Courses</p>
                </div>
              </div>
              <div class="col-4 mb-3">
                <div class="p-3 border rounded text-nowrap">
                  <h3 class="text-success mb-1">{{ $students->payments->count() ?? 0 }}</h3>
                  <p class="text-muted mb-0">Payments</p>
                </div>
              </div>
              <div class="col-4 mb-3">
                <div class="p-3 border rounded text-nowrap">
                  <h3 class="text-info mb-1">{{ $students->gpa ?? '0.0' }}</h3>
                  <p class="text-muted mb-0">GPA</p>
                </div>
              </div>
            </div>
            
            <div class="mt-3">
              <h6 class="mb-3 text-nowrap">Tổng quan học tập</h6>
              <div class="progress mb-2" style="height: 10px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: {{ ($students->gpa ?? 0) * 25 }}%" aria-valuenow="{{ $students->gpa ?? 0 }}" aria-valuemin="0" aria-valuemax="4"></div>
              </div>
              <small class="text-muted text-nowrap">GPA: {{ $students->gpa ?? '0.0' }}/4.0</small>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    @if($students->enrollments && $students->enrollments->count() > 0)
    <div class="card mb-4">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0 text-nowrap">Enrolled Courses</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="table-light">
              <tr>
                <th class="text-nowrap">#</th>
                <th class="text-nowrap">Enrollment ID</th>
                <th class="text-nowrap">Course</th>
                <th class="text-nowrap">Class</th>
                <th class="text-nowrap">Join Date</th>
                <th class="text-nowrap">Fees</th>
                <th class="text-nowrap">Status</th>
                <th class="text-nowrap">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($students->enrollments as $enrollment)
              <tr>
                <td class="text-nowrap">{{ $loop->iteration }}</td>
                <td class="text-nowrap">{{ $enrollment->enroll_no }}</td>
                <td class="text-nowrap">{{ $enrollment->batch && $enrollment->batch->course ? $enrollment->batch->course->name : 'N/A' }}</td>
                <td class="text-nowrap">{{ $enrollment->batch ? $enrollment->batch->name : 'N/A' }}</td>
                <td class="text-nowrap">{{ date('d-m-Y', strtotime($enrollment->join_date)) }}</td>
                <td class="text-nowrap">{{ number_format($enrollment->fees, 0, ',', '.') }} đ</td>
                <td class="text-nowrap">
                  @php
                    $totalPaid = $enrollment->payments ? $enrollment->payments->sum('amount') : 0;
                    $percentPaid = $enrollment->fees > 0 ? ($totalPaid / $enrollment->fees) * 100 : 0;
                  @endphp
                  
                  @if($percentPaid >= 100)
                    <span class="badge bg-success text-nowrap">Paid</span>
                  @elseif($percentPaid > 0)
                    <span class="badge bg-warning text-nowrap">Partially Paid</span>
                  @else
                    <span class="badge bg-danger text-nowrap">Unpaid</span>
                  @endif
                </td>
                <td class="text-nowrap">
                  <a href="{{ url('/enrollments/' . $enrollment->id) }}" class="btn btn-sm btn-info text-nowrap">
                    <i class="bi bi-eye"></i> Details
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
        <h5 class="mb-0 text-nowrap">Payment History</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="table-light">
              <tr>
                <th class="text-nowrap">#</th>
                <th class="text-nowrap">Enrollment ID</th>
                <th class="text-nowrap">Payment Date</th>
                <th class="text-nowrap">Amount</th>
                <th class="text-nowrap">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($students->payments as $payment)
              <tr>
                <td class="text-nowrap">{{ $loop->iteration }}</td>
                <td class="text-nowrap">{{ $payment->enrollment ? $payment->enrollment->enroll_no : 'N/A' }}</td>
                <td class="text-nowrap">{{ date('d-m-Y', strtotime($payment->payment_date)) }}</td>
                <td class="text-nowrap">{{ number_format($payment->amount, 0, ',', '.') }} đ</td>
                <td class="text-nowrap">
                  <a href="{{ url('/payments/' . $payment->id) }}" class="btn btn-sm btn-info text-nowrap">
                    <i class="bi bi-eye"></i> Chi tiết
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th colspan="3" class="text-end text-nowrap">Total Payments:</th>
                <th class="text-nowrap">{{ number_format($students->payments->sum('amount'), 0, ',', '.') }} đ</th>
                <th></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
    @endif
    
    <div class="d-flex gap-2 flex-wrap">
      <a href="{{ url('/students') }}" class="btn btn-secondary text-nowrap">
        <i class="bi bi-arrow-left"></i> Back
      </a>
      <a href="{{ url('/students/' . $students->id . '/edit') }}" class="btn btn-primary text-nowrap">
        <i class="bi bi-pencil-square"></i> Edit
      </a>
      <a href="{{ url('/enrollments/create?student_id=' . $students->id) }}" class="btn btn-success text-nowrap">
        <i class="bi bi-plus-circle"></i> Add New Enrollment
      </a>
    </div>
  </div>
</div>

@endsection