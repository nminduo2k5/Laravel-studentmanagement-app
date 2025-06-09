@extends('layout')
@section('content')
<div class="card">
  <div class="card-header">Payment Details</div>
  <div class="card-body">
    <div class="card-body">
      <h5 class="card-title">Payment ID: {{ $payments->id }}</h5>
      <div class="row mb-3">
        <div class="col-md-6">
          <h6>Student Information</h6>
          <p class="card-text">Name: {{ $payments->enrollment && $payments->enrollment->student ? $payments->enrollment->student->name : 'N/A' }}</p>
          <p class="card-text">Email: {{ $payments->enrollment && $payments->enrollment->student && $payments->enrollment->student->email ? $payments->enrollment->student->email : 'N/A' }}</p>
          <p class="card-text">Phone: {{ $payments->enrollment && $payments->enrollment->student && $payments->enrollment->student->mobile ? $payments->enrollment->student->mobile : 'N/A' }}</p>
        </div>
        <div class="col-md-6">
          <h6>Course Information</h6>
          <p class="card-text">Batch: {{ $payments->enrollment && $payments->enrollment->batch ? $payments->enrollment->batch->name : 'N/A' }}</p>
          <p class="card-text">Course: {{ $payments->enrollment && $payments->enrollment->batch && $payments->enrollment->batch->course ? $payments->enrollment->batch->course->name : 'N/A' }}</p>
          <p class="card-text">Enrollment No: {{ $payments->enrollment ? $payments->enrollment->enroll_no : 'N/A' }}</p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <h6>Payment Information</h6>
          <p class="card-text">Payment Date: {{ $payments->payment_date }}</p>
          <p class="card-text">Amount: {{ number_format($payments->amount, 2) }}</p>
        </div>
      </div>
      <div class="mt-3">
        <a href="{{ url('/payments') }}" class="btn btn-secondary">Back to Payments</a>
        <a href="{{ url('/payments/' . $payments->id . '/edit') }}" class="btn btn-primary">Edit Payment</a>
      </div>
    </div>
  </div>
</div>
@endsection