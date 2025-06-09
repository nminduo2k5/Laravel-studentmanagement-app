@extends('layout')
@section('content')
 
<div class="card">
  <div class="card-header">Enrollment Details</div>
  <div class="card-body">
    <div class="row mb-4">
      <div class="col-md-6">
        <h5 class="card-title">Enrollment Information</h5>
        <p class="card-text"><strong>Enrollment No:</strong> {{ $enrollments->enroll_no }}</p>
        <p class="card-text"><strong>Join Date:</strong> {{ date('d-m-Y', strtotime($enrollments->join_date)) }}</p>
        <p class="card-text"><strong>Fees:</strong> {{ number_format($enrollments->fees, 2) }}</p>
      </div>
      
      <div class="col-md-6">
        <h5 class="card-title">Student Information</h5>
        <p class="card-text"><strong>Name:</strong> {{ $enrollments->student ? $enrollments->student->name : 'N/A' }}</p>
        <p class="card-text"><strong>Address:</strong> {{ $enrollments->student ? $enrollments->student->address : 'N/A' }}</p>
        <p class="card-text"><strong>Mobile:</strong> {{ $enrollments->student ? $enrollments->student->mobile : 'N/A' }}</p>
      </div>
    </div>
    
    <div class="row">
      <div class="col-md-6">
        <h5 class="card-title">Course Information</h5>
        <p class="card-text"><strong>Batch:</strong> {{ $enrollments->batch ? $enrollments->batch->name : 'N/A' }}</p>
        <p class="card-text"><strong>Course:</strong> {{ $enrollments->batch && $enrollments->batch->course ? $enrollments->batch->course->name : 'N/A' }}</p>
        <p class="card-text"><strong>Start Date:</strong> {{ $enrollments->batch && $enrollments->batch->start_date ? date('d-m-Y', strtotime($enrollments->batch->start_date)) : 'N/A' }}</p>
      </div>
    </div>
    
    <div class="mt-4">
      <a href="{{ url('/enrollments') }}" class="btn btn-secondary">Back to Enrollments</a>
      <a href="{{ url('/enrollments/' . $enrollments->id . '/edit') }}" class="btn btn-primary">Edit Enrollment</a>
    </div>
  </div>
</div>

@endsection