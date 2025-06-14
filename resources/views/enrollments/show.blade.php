@extends('layout')
@section('content')
 
<div class="card">
  <div class="card-header">Enrollment Details</div>
  <div class="card-body">
    <div class="row mb-4">
      <div class="col-md-6">
        <h5 class="card-title">Enrollment Information</h5>
        <p class="card-text"><strong>Enrollment No:</strong> {{ $enrollment->enroll_no }}</p>
        <p class="card-text"><strong>Join Date:</strong> {{ date('d-m-Y', strtotime($enrollment->join_date)) }}</p>
        <p class="card-text"><strong>Fees:</strong> {{ number_format($enrollment->fees, 2) }}</p>
      </div>
      
      <div class="col-md-6">
        <h5 class="card-title">Student Information</h5>
        <p class="card-text"><strong>Name:</strong> {{ $enrollment->student ? $enrollment->student->name : 'N/A' }}</p>
        <p class="card-text"><strong>Address:</strong> {{ $enrollment->student ? $enrollment->student->address : 'N/A' }}</p>
        <p class="card-text"><strong>Mobile:</strong> {{ $enrollment->student ? $enrollment->student->mobile : 'N/A' }}</p>
      </div>
    </div>
    
    <div class="row mb-4">
      <div class="col-md-6">
        <h5 class="card-title">Course Information</h5>
        <p class="card-text"><strong>Class:</strong> {{ $enrollment->batch ? $enrollment->batch->name : 'N/A' }}</p>
        <p class="card-text"><strong>Course:</strong> {{ $enrollment->batch && $enrollment->batch->course ? $enrollment->batch->course->name : 'N/A' }}</p>
        <p class="card-text"><strong>Start Date:</strong> {{ $enrollment->batch && $enrollment->batch->start_date ? date('d-m-Y', strtotime($enrollment->batch->start_date)) : 'N/A' }}</p>
      </div>
    </div>
    
    @if($enrollment->payments && $enrollment->payments->count() > 0)
    <div class="row">
      <div class="col-12">
        <h5 class="card-title">Payment History</h5>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Payment Date</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody>
              @foreach($enrollment->payments as $payment)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ date('d-m-Y', strtotime($payment->payment_date)) }}</td>
                <td>{{ number_format($payment->amount, 2) }}</td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th colspan="2" class="text-end">Total Paid:</th>
                <th>{{ number_format($enrollment->payments->sum('amount'), 2) }}</th>
              </tr>
              <tr>
                <th colspan="2" class="text-end">Balance:</th>
                <th>{{ number_format($enrollment->fees - $enrollment->payments->sum('amount'), 2) }}</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
    @endif
    
    <div class="mt-4">
      <a href="{{ url('/enrollments') }}" class="btn btn-secondary">Back to Enrollments</a>
      <a href="{{ url('/enrollments/' . $enrollment->id . '/edit') }}" class="btn btn-primary">Edit Enrollment</a>
      <a href="{{ url('/payments/create?enrollment_id=' . $enrollment->id) }}" class="btn btn-success">Add Payment</a>
    </div>
  </div>
</div>

@endsection