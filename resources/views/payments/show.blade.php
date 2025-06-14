@extends('layout')
@section('content')
<div class="card">
  <div class="card-header">Payment Details</div>
  <div class="card-body">
      <h5 class="card-title">Payment ID: {{ $payment->id }}</h5>
      <div class="row mb-3">
        <div class="col-md-6">
          <h6>Student Information</h6>
          <p class="card-text"><strong>Name:</strong> {{ $payment->enrollment && $payment->enrollment->student ? $payment->enrollment->student->name : 'N/A' }}</p>
          <p class="card-text"><strong>Email:</strong> {{ $payment->enrollment && $payment->enrollment->student && $payment->enrollment->student->email ? $payment->enrollment->student->email : 'N/A' }}</p>
          <p class="card-text"><strong>Phone:</strong> {{ $payment->enrollment && $payment->enrollment->student && $payment->enrollment->student->mobile ? $payment->enrollment->student->mobile : 'N/A' }}</p>
        </div>
        <div class="col-md-6">
          <h6>Course Information</h6>
          <p class="card-text"><strong>Batch:</strong> {{ $payment->enrollment && $payment->enrollment->batch ? $payment->enrollment->batch->name : 'N/A' }}</p>
          <p class="card-text"><strong>Course:</strong> {{ $payment->enrollment && $payment->enrollment->batch && $payment->enrollment->batch->course ? $payment->enrollment->batch->course->name : 'N/A' }}</p>
          <p class="card-text"><strong>Enrollment No:</strong> {{ $payment->enrollment ? $payment->enrollment->enroll_no : 'N/A' }}</p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <h6>Payment Information</h6>
          <p class="card-text"><strong>Payment Date:</strong> {{ date('d-m-Y', strtotime($payment->payment_date)) }}</p>
          <p class="card-text"><strong>Amount:</strong> {{ number_format($payment->amount, 2) }}</p>
        </div>
      </div>
      <div class="mt-3">
        <a href="{{ url('/payments') }}" class="btn btn-secondary">Back to Payments</a>
        <a href="{{ url('/payments/' . $payment->id . '/edit') }}" class="btn btn-primary">Edit Payment</a>
        @if($payment->enrollment)
        <a href="{{ url('/enrollments/' . $payment->enrollment->id) }}" class="btn btn-info">View Enrollment</a>
        @endif
      </div>
  </div>
</div>
@endsection