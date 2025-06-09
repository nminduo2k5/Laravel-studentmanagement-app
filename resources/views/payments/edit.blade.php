@extends('layout')
@section('content')
 
<div class="card">
  <div class="card-header">Edit Payment</div>
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
      
      <form action="{{ url('payments/' . $payment->id) }}" method="post">
        {!! csrf_field() !!}
        @method("PATCH")
        <input type="hidden" name="id" value="{{ $payment->id }}" />
        <div class="form-group mb-3">
          <label>Student Enrollment</label>
          <select name="enrollment_id" class="form-control">
              <option value="">Select Student Enrollment</option>
              @foreach($enrollments as $id => $text)
                  <option value="{{ $id }}" {{ $payment->enrollment_id == $id ? 'selected' : '' }}>{{ $text }}</option>
              @endforeach
          </select>
        </div>
        <div class="form-group mb-3">
          <label>Payment Date</label>
          <input type="date" name="payment_date" value="{{ $payment->payment_date }}" class="form-control">
        </div>
        <div class="form-group mb-3">
          <label>Amount</label>
          <input type="number" name="amount" value="{{ $payment->amount }}" class="form-control" step="0.01">
        </div>
        <input type="submit" value="Update" class="btn btn-success">
      </form>
  </div>
</div>
 
@stop