@extends('layout')
@section('content')
 
<div class="card">
  <div class="card-header">Edit Enrollment</div>
  <div class="card-body">
      @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
      @endif
      
      <form action="{{ url('enrollments/' .$enrollment->id) }}" method="post">
        {!! csrf_field() !!}
        @method("PATCH")
        <input type="hidden" name="id" id="id" value="{{$enrollment->id}}" />
        
        <div class="form-group mb-3">
          <label>Enrollment Number</label>
          <input type="text" name="enroll_no" id="enroll_no" value="{{$enrollment->enroll_no}}" class="form-control">
        </div>
        
        <div class="form-group mb-3">
          <label>Student</label>
          <select name="student_id" id="student_id" class="form-control">
            <option value="">Select Student</option>
            @foreach($students as $id => $name)
              <option value="{{ $id }}" {{ $enrollment->student_id == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
          </select>
        </div>
        
        <div class="form-group mb-3">
          <label>Class</label>
          <select name="batch_id" id="batch_id" class="form-control">
            <option value="">Select Batch</option>
            @foreach($batches as $id => $name)
              <option value="{{ $id }}" {{ $enrollment->batch_id == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
          </select>
        </div>
        
        <div class="form-group mb-3">
          <label>Join Date</label>
          <input type="date" name="join_date" id="join_date" value="{{$enrollment->join_date ?? \Carbon\Carbon::now()->format('Y-m-d')}}" class="form-control">
        </div>
        
        <div class="form-group mb-3">
          <label>Fees</label>
          <input type="number" name="fees" id="fees" value="{{$enrollment->fees}}" class="form-control" step="0.01">
        </div>
        
        <input type="submit" value="Update" class="btn btn-success">
      </form>
   
  </div>
</div>
 
@stop