@extends('layout')
@section('content')
 
 
<div class="card">
  <div class="card-header">Courses Page</div>
  <div class="card-body">
   
 
        <div class="card-body">
        <h5 class="card-title">Enroll_No : {{ $enrollments->enroll_no }}</h5>
        <p class="card-title">Batch_ID : {{ $enrollments->batch_id }}</p>
        <p class="card-title">Student_ID : {{ $enrollments->student_id }}</p>
        <p class="card-title">Join_Date : {{ $enrollments->join_date }}</p>
        <p class="card-title">Fees : {{ $enrollments->fees }}</p>
  </div>
       
    </hr>
  
  </div>
</div>

@endsection