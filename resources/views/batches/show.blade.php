@extends('layout')
@section('content')

<div class="card">
  <div class="card-header">
    <h4>Class Details</h4>
  </div>
  <div class="card-body">
    <div class="row mb-4">
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Class Information</h5>
          </div>
          <div class="card-body">
            <h4 class="mb-3">{{ $batches->name }}</h4>
            <p><strong><i class="bi bi-calendar-date me-2"></i>Start Date:</strong> {{ \Carbon\Carbon::parse($batches->start_date)->format('d/m/Y') }}</p>
            <p><strong><i class="bi bi-people me-2"></i>Number of Students:</strong> {{ $batches->enrollments->count() }}</p>
            
            @php
              $totalFees = $batches->enrollments->sum('fees');
              $totalPaid = 0;
              foreach($batches->enrollments as $enrollment) {
                $totalPaid += $enrollment->payments->sum('amount');
              }
              $percentPaid = $totalFees > 0 ? ($totalPaid / $totalFees) * 100 : 0;
            @endphp
            
            <p><strong><i class="bi bi-cash-coin me-2"></i>Total Fees:</strong> {{ number_format($totalFees, 0, ',', '.') }} đ</p>
            <p><strong><i class="bi bi-credit-card me-2"></i>Paid Amount:</strong> {{ number_format($totalPaid, 0, ',', '.') }} đ ({{ number_format($percentPaid, 1) }}%)</p>
            
            <div class="progress mt-2" style="height: 10px;">
              <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentPaid }}%" aria-valuenow="{{ $percentPaid }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-header bg-info text-white">
            <h5 class="mb-0">Course Information</h5>
          </div>
          <div class="card-body">
            <h4 class="mb-3">{{ $batches->course->name }}</h4>
            <p><strong><i class="bi bi-book me-2"></i>Syllabus:</strong> {{ $batches->course->syllabus }}</p>
            <p><strong><i class="bi bi-clock me-2"></i>Duration:</strong> {{ $batches->course->duration() }}</p>
            
            @if($batches->course->teachers && $batches->course->teachers->count() > 0)
              <p><strong><i class="bi bi-person-workspace me-2"></i>Teachers:</strong></p>
              <ul class="list-group">
                @foreach($batches->course->teachers as $teacher)
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $teacher->name }}
                    @if($teacher->pivot && $teacher->pivot->is_primary)
                      <span class="badge bg-primary rounded-pill">Primary Teacher</span>
                    @endif
                  </li>
                @endforeach
              </ul>
            @else
              <p><strong><i class="bi bi-person-workspace me-2"></i>Teachers:</strong> Not assigned yet</p>
            @endif
          </div>
        </div>
      </div>
    </div>
    
    <div class="card mb-4">
      <div class="card-header bg-success text-white">
        <h5 class="mb-0">Enrolled Students</h5>
      </div>
      <div class="card-body">
        @if($batches->enrollments && $batches->enrollments->count() > 0)
          <div class="table-responsive">
            <table class="table table-hover">
              <thead class="table-light">
                <tr>
                  <th>#</th>
                  <th>Enrollment ID</th>
                  <th>Student Name</th>
                  <th>Join Date</th>
                  <th>Fees</th>
                  <th>Paid Amount</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($batches->enrollments as $enrollment)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $enrollment->enroll_no }}</td>
                  <td>{{ $enrollment->student ? $enrollment->student->name : 'N/A' }}</td>
                  <td>{{ date('d-m-Y', strtotime($enrollment->join_date)) }}</td>
                  <td>{{ number_format($enrollment->fees, 0, ',', '.') }} đ</td>
                  <td>
                    @php
                      $paid = $enrollment->payments ? $enrollment->payments->sum('amount') : 0;
                      $percentPaid = $enrollment->fees > 0 ? ($paid / $enrollment->fees) * 100 : 0;
                    @endphp
                    {{ number_format($paid, 0, ',', '.') }} đ
                    <div class="progress mt-1" style="height: 5px;">
                      <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentPaid }}%" aria-valuenow="{{ $percentPaid }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </td>
                  <td>
                    @if($percentPaid >= 100)
                      <span class="badge bg-success">Paid</span>
                    @elseif($percentPaid > 0)
                      <span class="badge bg-warning">Partially Paid</span>
                    @else
                      <span class="badge bg-danger">Unpaid</span>
                    @endif
                  </td>
                  <td>
                    <div class="btn-group">
                      <a href="{{ url('/enrollments/' . $enrollment->id) }}" class="btn btn-sm btn-info">
                        <i class="bi bi-eye"></i>
                      </a>
                      <a href="{{ url('/payments/create?enrollment_id=' . $enrollment->id) }}" class="btn btn-sm btn-success">
                        <i class="bi bi-cash"></i>
                      </a>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="4" class="text-end">Total:</th>
                  <th>{{ number_format($totalFees, 0, ',', '.') }} đ</th>
                  <th>{{ number_format($totalPaid, 0, ',', '.') }} đ</th>
                  <th colspan="2"></th>
                </tr>
              </tfoot>
            </table>
          </div>
        @else
          <div class="alert alert-info">
            No students enrolled in this class yet.
          </div>
        @endif
      </div>
    </div>
    
    <div class="d-flex gap-2">
      <a href="{{ url('/batches') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back
      </a>
      <a href="{{ url('/batches/' . $batches->id . '/edit') }}" class="btn btn-primary">
        <i class="bi bi-pencil-square"></i> Edit
      </a>
      <a href="{{ url('/enrollments/create?batch_id=' . $batches->id) }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Add Student
      </a>
      <a href="{{ url('/courses/' . $batches->course->id) }}" class="btn btn-info">
        <i class="bi bi-book"></i> View Course
      </a>
    </div>
  </div>
</div>

@endsection