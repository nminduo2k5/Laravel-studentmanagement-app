@extends('layout')
@section('content')

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Enrollment Details</h4>
    <span class="badge bg-{{ $enrollment->payments->sum('amount') >= $enrollment->fees ? 'success' : ($enrollment->payments->sum('amount') > 0 ? 'warning' : 'danger') }}">
      {{ $enrollment->payments->sum('amount') >= $enrollment->fees ? 'Paid' : ($enrollment->payments->sum('amount') > 0 ? 'Partially Paid' : 'Unpaid') }}
    </span>
  </div>
  <div class="card-body">
    <div class="row mb-4">
      <div class="col-md-4">
        <div class="card h-100">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Enrollment Information</h5>
          </div>
          <div class="card-body">
            <p><i class="bi bi-hash me-2"></i><strong>Enrollment No:</strong> {{ $enrollment->enroll_no }}</p>
            <p><i class="bi bi-calendar-date me-2"></i><strong>Join Date:</strong> {{ date('d-m-Y', strtotime($enrollment->join_date)) }}</p>
            <p><i class="bi bi-cash-coin me-2"></i><strong>Fees:</strong> {{ number_format($enrollment->fees, 2) }}</p>
            
            @php
              $paidAmount = $enrollment->payments->sum('amount');
              $balance = $enrollment->fees - $paidAmount;
              $percentPaid = $enrollment->fees > 0 ? ($paidAmount / $enrollment->fees) * 100 : 0;
            @endphp
            
            <div class="mt-3">
              <p class="mb-1"><strong>Payment Status:</strong></p>
              <div class="progress" style="height: 20px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentPaid }}%" 
                     aria-valuenow="{{ $percentPaid }}" aria-valuemin="0" aria-valuemax="100">
                  {{ number_format($percentPaid, 0) }}%
                </div>
              </div>
              <div class="d-flex justify-content-between mt-1">
                <small>Paid: {{ number_format($paidAmount, 2) }}</small>
                <small>Balance: {{ number_format($balance, 2) }}</small>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="card h-100">
          <div class="card-header bg-info text-white">
            <h5 class="mb-0">Student Information</h5>
          </div>
          <div class="card-body">
            @if($enrollment->student)
              <div class="d-flex align-items-center mb-3">
                <div class="avatar-placeholder bg-light rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                  <i class="bi bi-person fs-3"></i>
                </div>
                <div>
                  <h5 class="mb-0">{{ $enrollment->student->name }}</h5>
                  <p class="text-muted mb-0">ID: {{ $enrollment->student->id }}</p>
                </div>
              </div>
              <p><i class="bi bi-geo-alt me-2"></i><strong>Address:</strong> {{ $enrollment->student->address }}</p>
              <p><i class="bi bi-telephone me-2"></i><strong>Mobile:</strong> {{ $enrollment->student->mobile }}</p>
              <a href="{{ url('/students/' . $enrollment->student->id) }}" class="btn btn-sm btn-outline-primary mt-2">
                <i class="bi bi-person-badge"></i> View Student Profile
              </a>
            @else
              <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle"></i> Student information not available
              </div>
            @endif
          </div>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="card h-100">
          <div class="card-header bg-success text-white">
            <h5 class="mb-0">Course Information</h5>
          </div>
          <div class="card-body">
            @if($enrollment->batch && $enrollment->batch->course)
              <h5 class="mb-3">{{ $enrollment->batch->course->name }}</h5>
              <p><i class="bi bi-collection me-2"></i><strong>Class:</strong> {{ $enrollment->batch->name }}</p>
              <p><i class="bi bi-calendar-date me-2"></i><strong>Start Date:</strong> 
                {{ date('d-m-Y', strtotime($enrollment->batch->start_date)) }}
              </p>
              <p><i class="bi bi-clock me-2"></i><strong>Duration:</strong> {{ $enrollment->batch->course->duration() }}</p>
              <a href="{{ url('/batches/' . $enrollment->batch->id) }}" class="btn btn-sm btn-outline-success mt-2">
                <i class="bi bi-people"></i> View Class Details
              </a>
            @else
              <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle"></i> Course information not available
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
    
    <div class="card mb-4">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Payment History</h5>
      </div>
      <div class="card-body">
        @if($enrollment->payments && $enrollment->payments->count() > 0)
          <div class="table-responsive">
            <table class="table table-hover">
              <thead class="table-light">
                <tr>
                  <th>#</th>
                  <th>Payment Date</th>
                  <th>Amount</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($enrollment->payments as $payment)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ date('d-m-Y', strtotime($payment->payment_date)) }}</td>
                  <td>{{ number_format($payment->amount, 2) }}</td>
                  <td>
                    <a href="{{ url('/payments/' . $payment->id) }}" class="btn btn-sm btn-info">
                      <i class="bi bi-eye"></i>
                    </a>
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="2" class="text-end">Total Paid:</th>
                  <th>{{ number_format($enrollment->payments->sum('amount'), 2) }}</th>
                  <th></th>
                </tr>
                <tr>
                  <th colspan="2" class="text-end">Balance:</th>
                  <th>{{ number_format($enrollment->fees - $enrollment->payments->sum('amount'), 2) }}</th>
                  <th></th>
                </tr>
              </tfoot>
            </table>
          </div>
        @else
          <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> No payment records found for this enrollment.
          </div>
        @endif
      </div>
    </div>
    
    <div class="d-flex gap-2">
      <a href="{{ url('/enrollments') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Enrollments
      </a>
      <a href="{{ url('/enrollments/' . $enrollment->id . '/edit') }}" class="btn btn-primary">
        <i class="bi bi-pencil-square"></i> Edit Enrollment
      </a>
      <a href="{{ url('/payments/create?enrollment_id=' . $enrollment->id) }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Add Payment
      </a>
      @if($enrollment->student)
      <a href="{{ url('/students/' . $enrollment->student->id) }}" class="btn btn-info">
        <i class="bi bi-person"></i> View Student
      </a>
      @endif
    </div>
  </div>
</div>

@endsection