@extends('layout')
@section('content')

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Payment Details</h4>
    <span class="badge bg-success">Paid</span>
  </div>
  <div class="card-body">
    <div class="row mb-4">
      <div class="col-md-4">
        <div class="card h-100">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Payment Information</h5>
          </div>
          <div class="card-body">
            <div class="text-center mb-3">
              <div class="bg-light rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                <i class="bi bi-credit-card fs-1 text-primary"></i>
              </div>
              <h4 class="mt-2">{{ number_format($payment->amount, 2) }}</h4>
              <p class="text-muted">Payment #{{ $payment->id }}</p>
            </div>
            
            <p><i class="bi bi-calendar-date me-2"></i><strong>Payment Date:</strong> {{ date('d-m-Y', strtotime($payment->payment_date)) }}</p>
            
            @if($payment->enrollment)
              @php
                $totalPaid = $payment->enrollment->payments->sum('amount');
                $totalFees = $payment->enrollment->fees;
                $percentPaid = $totalFees > 0 ? min(100, ($totalPaid / $totalFees) * 100) : 0;
              @endphp
              
              <div class="mt-3">
                <p class="mb-1"><strong>Payment Progress:</strong></p>
                <div class="progress" style="height: 20px;">
                  <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentPaid }}%" 
                       aria-valuenow="{{ $percentPaid }}" aria-valuemin="0" aria-valuemax="100">
                    {{ number_format($percentPaid, 0) }}%
                  </div>
                </div>
                <div class="d-flex justify-content-between mt-1">
                  <small>Total Paid: {{ number_format($totalPaid, 2) }}</small>
                  <small>Total Fees: {{ number_format($totalFees, 2) }}</small>
                </div>
              </div>
            @endif
          </div>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="card h-100">
          <div class="card-header bg-info text-white">
            <h5 class="mb-0">Student Information</h5>
          </div>
          <div class="card-body">
            @if($payment->enrollment && $payment->enrollment->student)
              <div class="d-flex align-items-center mb-3">
                <div class="bg-light rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                  <i class="bi bi-person fs-3"></i>
                </div>
                <div>
                  <h5 class="mb-0">{{ $payment->enrollment->student->name }}</h5>
                  <p class="text-muted mb-0">ID: {{ $payment->enrollment->student->id }}</p>
                </div>
              </div>

              <p><i class="bi bi-geo-alt me-2"></i><strong>Address:</strong> {{ $payment->enrollment->student->address }}</p>
              <p><i class="bi bi-telephone me-2"></i><strong>Mobile:</strong> {{ $payment->enrollment->student->mobile }}</p>
              <a href="{{ url('/students/' . $payment->enrollment->student->id) }}" class="btn btn-sm btn-outline-primary mt-2">
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
            <h5 class="mb-0">Enrollment Information</h5>
          </div>
          <div class="card-body">
            @if($payment->enrollment)
              <p><i class="bi bi-hash me-2"></i><strong>Enrollment No:</strong> 
                {{ $payment->enrollment->enroll_no }}
              </p>
              
              @if($payment->enrollment->batch && $payment->enrollment->batch->course)
                <p><i class="bi bi-collection me-2"></i><strong>Class:</strong> 
                  {{ $payment->enrollment->batch->name }}
                </p>
                <p><i class="bi bi-book me-2"></i><strong>Course:</strong> 
                  {{ $payment->enrollment->batch->course->name }}
                </p>
                <p><i class="bi bi-calendar-date me-2"></i><strong>Join Date:</strong> 
                  {{ date('d-m-Y', strtotime($payment->enrollment->join_date)) }}
                </p>
              @else
                <div class="alert alert-warning">
                  <i class="bi bi-exclamation-triangle"></i> Course information not available
                </div>
              @endif
              
              <a href="{{ url('/enrollments/' . $payment->enrollment->id) }}" class="btn btn-sm btn-outline-success mt-2">
                <i class="bi bi-file-earmark-text"></i> View Enrollment Details
              </a>
            @else
              <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle"></i> Enrollment information not available
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
    
    @if($payment->enrollment)
      <div class="card mb-4">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Payment History</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead class="table-light">
                <tr>
                  <th>#</th>
                  <th>Payment Date</th>
                  <th>Amount</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach($payment->enrollment->payments as $p)
                <tr class="{{ $p->id == $payment->id ? 'table-primary' : '' }}">
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ date('d-m-Y', strtotime($p->payment_date)) }}</td>
                  <td>{{ number_format($p->amount, 2) }}</td>
                  <td>
                    @if($p->id == $payment->id)
                      <span class="badge bg-primary">Current</span>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="2" class="text-end">Total Paid:</th>
                  <th>{{ number_format($payment->enrollment->payments->sum('amount'), 2) }}</th>
                  <th></th>
                </tr>
                <tr>
                  <th colspan="2" class="text-end">Balance:</th>
                  <th>{{ number_format($payment->enrollment->fees - $payment->enrollment->payments->sum('amount'), 2) }}</th>
                  <th></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    @endif
    
    <div class="d-flex gap-2">
      <a href="{{ url('/payments') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Payments
      </a>
      <a href="{{ url('/payments/' . $payment->id . '/edit') }}" class="btn btn-primary">
        <i class="bi bi-pencil-square"></i> Edit Payment
      </a>
      @if($payment->enrollment)
        <a href="{{ url('/enrollments/' . $payment->enrollment->id) }}" class="btn btn-info">
          <i class="bi bi-file-earmark-text"></i> View Enrollment
        </a>
        @if($payment->enrollment->student)
          <a href="{{ url('/students/' . $payment->enrollment->student->id) }}" class="btn btn-success">
            <i class="bi bi-person"></i> View Student
          </a>
        @endif
      @endif
    </div>
  </div>
</div>

@endsection