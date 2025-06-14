@extends('layout')
@section('content')
 
<div class="card">
  <div class="card-header">Add Payment</div>
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
      
      <form action="{{ url('payments') }}" method="post">
        {!! csrf_field() !!}
        <div class="form-group mb-3">
          <label>Student Enrollment</label>
          <select name="enrollment_id" class="form-control">
              <option value="">Select Student Enrollment</option>
              @foreach($enrollments as $id => $text)
                  <option value="{{ $id }}" {{ isset($selectedEnrollmentId) && $selectedEnrollmentId == $id ? 'selected' : '' }}>{{ $text }}</option>
              @endforeach
          </select>
        </div>
        <div class="form-group mb-3">
          <label>Payment Date</label>
          <input type="date" name="payment_date" class="form-control" value="{{ old('payment_date', date('Y-m-d')) }}">
        </div>
        <div class="form-group mb-3">
          <label>Amount</label>
          <input type="number" name="amount" class="form-control" step="0.01" value="{{ old('amount') }}">
        </div>
        <input type="submit" value="Save" class="btn btn-success">
      </form>
  </div>
</div>
 
@stop