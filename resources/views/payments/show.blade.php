@extends('layout')
@section('content')
<div class="card">
  <div class="card-header">Payment Details</div>
  <div class="card-body">
    <div class="card-body">
      <h5 class="card-title">ID: {{ $payments->id }}</h5>
      <p class="card-text">Enrollment ID: {{ $payments->enrollment_id }}</p>
      <p class="card-text">Payment Date: {{ $payments->payment_date }}</p>
      <p class="card-text">Amount: {{ $payments->amount }}</p>
    </div>
  </div>
</div>
@endsection