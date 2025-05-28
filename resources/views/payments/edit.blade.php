@extends('layout')
@section('content')
 
<div class="card">
  <div class="card-header">Edit Payment</div>
  <div class="card-body">
      <form action="{{ url('payments/' . $payments->id) }}" method="post">
        {!! csrf_field() !!}
        @method("PATCH")
        <input type="hidden" name="id" value="{{ $payments->id }}" />
        <label>Enrollment ID</label></br>
        <input type="text" name="enrollment_id" value="{{ $payments->enrollment_id }}" class="form-control"></br>
        <label>Payment Date</label></br>
        <input type="date" name="payment_date" value="{{ $payments->payment_date }}" class="form-control"></br>
        <label>Amount</label></br>
        <input type="number" name="amount" value="{{ $payments->amount }}" class="form-control" step="0.01"></br>
        <input type="submit" value="Update" class="btn btn-success"></br>
      </form>
  </div>
</div>
 
@stop