@extends('layout')
@section('content')
 
<div class="card">
  <div class="card-header">
    <h4>Edit Teacher</h4>
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
      
    <form action="{{ url('teachers/' . $teacher->id) }}" method="post">
      {!! csrf_field() !!}
      @method("PATCH")
      <input type="hidden" name="id" id="id" value="{{ $teacher->id }}" />
      
      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" value="{{ $teacher->name }}" class="form-control">
          </div>
          
    
          <div class="mb-3">
            <label for="mobile" class="form-label">Phone</label>
            <input type="text" name="mobile" id="mobile" value="{{ $teacher->mobile }}" class="form-control">
          </div>
          
          <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea name="address" id="address" class="form-control" rows="3">{{ $teacher->address }}</textarea>
          </div>
        </div>
        
        <div class="col-md-6">
          <div class="mb-3">
            <label for="specialization" class="form-label">Specialization</label>
            <input type="text" name="specialization" id="specialization" value="{{ $teacher->specialization }}" class="form-control">
          </div>
          
          <div class="mb-3">
            <label for="qualification" class="form-label">Qualification</label>
            <input type="text" name="qualification" id="qualification" value="{{ $teacher->qualification }}" class="form-control">
          </div>
          
          <div class="mb-3">
            <label for="experience" class="form-label">Years of Experience</label>
            <input type="number" name="experience" id="experience" value="{{ $teacher->experience }}" class="form-control">
          </div>
          
          <div class="mb-3">
            <label for="join_date" class="form-label">Join Date</label>
            <input type="date" name="join_date" id="join_date" value="{{ $teacher->join_date }}" class="form-control">
          </div>
        </div>
      </div>
      
      <div class="d-flex gap-2 mt-3">
        <a href="{{ url('/teachers') }}" class="btn btn-secondary">
          <i class="bi bi-arrow-left"></i> Back
        </a>
        <button type="submit" class="btn btn-primary">
          <i class="bi bi-save"></i> Save Changes
        </button>
      </div>
    </form>
  </div>
</div>
 
@stop