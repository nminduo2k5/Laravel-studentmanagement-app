@extends('layout')
@section('content')
 
<div class="card">
  <div class="card-header">Add Payment</div>
  <div class="card-body">
      <form action="{{ url('payments') }}" method="post">
        {!! csrf_field() !!}
        <label>Enrollment ID</label></br>
        <input type="text" name="enrollment_id" class="form-control"></br>
        <label>Payment Date</label></br>
        <input type="date" name="payment_date" class="form-control"></br>
        <label>Amount</label></br>
        <input type="number" name="amount" class="form-control" step="0.01"></br>
        <input type="submit" value="Save" class="btn btn-success"></br>
      </form>
  </div>
</div>
 
@stop