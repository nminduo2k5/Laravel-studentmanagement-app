@extends('layout')
@section('content')
 
<div class="card">
  <div class="card-header">Edit Page</div>
  <div class="card-body">
      
      <form action="{{ url('enrollments/' .$enrollments->id) }}" method="post">
        {!! csrf_field() !!}
        @method("PATCH")
        <input type="hidden" name="id" id="id" value="{{$enrollments->id}}" id="id" />
        <label>Enroll_No</label></br>
        <input type="text" name="enroll_no" id="enroll_no" value="{{$enrollments->enroll_no}}" class="form-control" required></br>
        <label>Batch_ID</label></br>
        <input type="text" name="batch_id" id="batch_id" value="{{$enrollments->batch_id}}" class="form-control"></br>
        <label>Student_ID</label></br>
        <input type="text" name="student_id" id="student_id" value="{{$enrollments->student_id}}" class="form-control"></br>
        <label>Join_Date</label></br>
        <input type="date" name="join_date" id="join_date" value="{{$enrollments->join_date ?? \Carbon\Carbon::now()->format('Y-m-d')}}" class="form-control" required></br>
        <label>Fees</label></br>
        <input type="text" name="fees" id="fees" value="{{$enrollments->fees}}" class="form-control"></br>
        <input type="submit" value="Update" class="btn btn-success"></br>
    </form>
   
  </div>
</div>
 
@stop