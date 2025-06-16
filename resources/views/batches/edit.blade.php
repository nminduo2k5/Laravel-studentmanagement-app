@extends('layout')
@section('content')
 
<div class="card">
  <div class="card-header">
    <h4>Edit class</h4>
  </div>
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
      
    <form action="{{ url('batches/' . $batches->id) }}" method="post">
      {!! csrf_field() !!}
      @method("PATCH")
      <input type="hidden" name="id" id="id" value="{{ $batches->id }}" />
      
      <div class="mb-3">
        <label for="name" class="form-label">Class Name</label>
        <input type="text" name="name" id="name" value="{{ $batches->name }}" class="form-control" required>
      </div>
      
      <div class="mb-3">
        <label for="course_id" class="form-label">Course</label>
        <select name="course_id" id="course_id" class="form-control" required>
          <option value="">-- Select Course --</option>
          @foreach($courses as $id => $name)
            <option value="{{ $id }}" {{ $batches->course_id == $id ? 'selected' : '' }}>{{ $name }}</option>
          @endforeach
        </select>
      </div>
      
      <div class="mb-3">
        <label for="start_date" class="form-label">Start Date</label>
        <input type="date" name="start_date" id="start_date" value="{{ \Carbon\Carbon::parse($batches->start_date)->format('Y-m-d') }}" class="form-control" required>
      </div>
      
      <div class="d-flex gap-2">
        <a href="{{ url('/batches') }}" class="btn btn-secondary">
          <i class="bi bi-arrow-left"></i> Back   
        </a>
        <button type="submit" class="btn btn-primary">
          <i class="bi bi-save"></i> Save changes
        </button>
      </div>
    </form>
  </div>
</div>
 
@stop