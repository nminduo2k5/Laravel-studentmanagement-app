@extends('layout')
@section('content')
 
<div class="card">
  <div class="card-header">Add New Enrollment</div>
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
      
      <form action="{{ url('enrollments') }}" method="post">
        {!! csrf_field() !!}
        <div class="form-group mb-3">
          <label>Enrollment Number</label>
          <input type="text" name="enroll_no" id="enroll_no" class="form-control" value="{{ old('enroll_no') }}">
        </div>
        
        <div class="form-group mb-3">
          <label>Student</label>
          <select name="student_id" id="student_id" class="form-control">
            <option value="">Select Student</option>
            @foreach($students as $id => $name)
              <option value="{{ $id }}" {{ old('student_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
          </select>
        </div>
        
        <div class="form-group mb-3">
          <label>Batch</label>
          <select name="batch_id" id="batch_id" class="form-control">
            <option value="">Select Batch</option>
            @foreach($batches as $id => $name)
              <option value="{{ $id }}" {{ old('batch_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
          </select>
        </div>
        
        <div class="form-group mb-3">
          <label>Join Date</label>
          <input type="date" name="join_date" id="join_date" class="form-control" value="{{ old('join_date', date('Y-m-d')) }}">
        </div>
        
        <div class="form-group mb-3">
          <label>Fees</label>
          <input type="number" name="fees" id="fees" class="form-control" step="0.01" value="{{ old('fees') }}">
        </div>
        
        <input type="submit" value="Save" class="btn btn-success">
      </form>
   
  </div>
</div>
 
@stop