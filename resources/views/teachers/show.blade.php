@extends('layout')
@section('content')

<div class="card">
  <div class="card-header">
    <h4>Teacher Information</h4>
  </div>
  <div class="card-body">
    <div class="row mb-4">
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Personal Information</h5>
          </div>
          <div class="card-body">
            <div class="d-flex mb-3">
              <div class="avatar-placeholder bg-light rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                <i class="bi bi-person-workspace fs-1"></i>
              </div>
              <div>
                <h4 class="mb-1">{{ $teacher->name }}</h4>
                <p class="text-muted mb-0">Teacher ID: {{ $teacher->id }}</p>
              </div>
            </div>
            <div class="mb-3">
              <p><strong><i class="bi bi-telephone me-2"></i>Phone:</strong> {{ $teacher->mobile }}</p>
              <p><strong><i class="bi bi-geo-alt me-2"></i>Address:</strong> {{ $teacher->address }}</p>
              <p><strong><i class="bi bi-briefcase me-2"></i>Specialization:</strong> {{ $teacher->specialization ?? 'N/A' }}</p>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-header bg-info text-white">
            <h5 class="mb-0">Teaching Information</h5>
          </div>
          <div class="card-body">
            <div class="row text-center">
              <div class="col-4 mb-3">
                <div class="p-3 border rounded">
                  <h3 class="text-primary mb-1">{{ $teacher->courses->count() }}</h3>
                  <p class="text-muted mb-0">Courses</p>
                </div>
              </div>
              <div class="col-4 mb-3">
                <div class="p-3 border rounded">
                  <h3 class="text-success mb-1">{{ $teacher->primaryCourses->count() }}</h3>
                  <p class="text-muted mb-0">Primary Courses</p>
                </div>
              </div>
              <div class="col-4 mb-3">
                <div class="p-3 border rounded">
                  <h3 class="text-info mb-1">{{ $teacher->experience ?? 0 }}</h3>
                  <p class="text-muted mb-0">Years of Experience</p>
                </div>
              </div>
            </div>
            
            <div class="mt-3">
              <h6 class="mb-3">Additional Information</h6>
              <p><strong>Qualification:</strong> {{ $teacher->qualification ?? 'N/A' }}</p>
              <p><strong>Join Date:</strong> {{ $teacher->join_date ? date('d-m-Y', strtotime($teacher->join_date)) : 'N/A' }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="card mb-4">
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Courses Teaching</h5>
        <a href="{{ route('teachers.courses', $teacher->id) }}" class="btn btn-sm btn-light">
          <i class="bi bi-list-ul"></i> View All Courses
        </a>
      </div>
      <div class="card-body">
        @if($teacher->courses->count() > 0)
        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Course Name</th>
                <th>Duration</th>
                <th>Role</th>
                <th>Primary Teacher</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($teacher->courses->take(5) as $course)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $course->name }}</td>
                <td>{{ $course->duration() }}</td>
                <td>{{ $course->pivot->role ?? 'N/A' }}</td>
                <td>
                  @if($course->pivot->is_primary)
                    <span class="badge bg-success">Primary Teacher</span>
                  @else
                    <span class="badge bg-secondary">Secondary Teacher</span>
                  @endif
                </td>
                <td>
                  <a href="{{ url('/courses/' . $course->id) }}" class="btn btn-sm btn-info">
                    <i class="bi bi-eye"></i> View Details
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          
          @if($teacher->courses->count() > 5)
          <div class="text-center mt-3">
            <a href="{{ route('teachers.courses', $teacher->id) }}" class="btn btn-outline-primary">
              View All {{ $teacher->courses->count() }} Courses
            </a>
          </div>
          @endif
        </div>
        @else
        <div class="alert alert-info">
          This teacher is not assigned to any courses.
        </div>
        @endif
      </div>
    </div>
    
    <div class="d-flex gap-2">
      <a href="{{ url('/teachers') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back
      </a>
      <a href="{{ url('/teachers/' . $teacher->id . '/edit') }}" class="btn btn-primary">
        <i class="bi bi-pencil-square"></i> Edit
      </a>
      <a href="{{ url('/courses/create?teacher_id=' . $teacher->id) }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Add Course
      </a>
      <a href="{{ route('teachers.courses', $teacher->id) }}" class="btn btn-info">
        <i class="bi bi-list-ul"></i> View All Courses
      </a>
    </div>
  </div>
</div>

@endsection