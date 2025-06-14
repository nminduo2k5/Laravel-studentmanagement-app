@extends('layout')
@section('content')

<div class="card">
  <div class="card-header">
    <h4 class="mb-0 text-nowrap">Course Details</h4>
  </div>
  <div class="card-body">
    <div class="row mb-4">
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0 text-nowrap">Course Information</h5>
          </div>
          <div class="card-body">
            <h4 class="mb-3 text-nowrap">{{ $course->name }}</h4>
            <p class="text-nowrap"><strong><i class="bi bi-book me-2"></i>Syllabus:</strong> {{ $course->syllabus }}</p>
            <p class="text-nowrap"><strong><i class="bi bi-clock me-2"></i>Duration:</strong> {{ $course->duration() }}</p>
          </div>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-header bg-info text-white">
            <h5 class="mb-0 text-nowrap">Statistics</h5>
          </div>
          <div class="card-body">
            <div class="row text-center">
              <div class="col-4 mb-3">
                <div class="p-3 border rounded text-nowrap">
                  <h3 class="text-primary mb-1">{{ $course->batches->count() }}</h3>
                  <p class="text-muted mb-0">Classes</p>
                </div>
              </div>
              <div class="col-4 mb-3">
                <div class="p-3 border rounded text-nowrap">
                  <h3 class="text-success mb-1">{{ $course->teachers->count() }}</h3>
                  <p class="text-muted mb-0">Teachers </p>
                </div>
              </div>
              <div class="col-4 mb-3">
                <div class="p-3 border rounded text-nowrap">
                  <h3 class="text-info mb-1">{{ $course->batches->sum(function($batch) { return $batch->enrollments->count(); }) }}</h3>
                  <p class="text-muted mb-0">Students</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="card mb-4">
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-nowrap">Teaching Information</h5>
        <a href="{{ route('courses.assign.teachers.form', $course->id) }}" class="btn btn-sm btn-light text-nowrap">
          <i class="bi bi-person-plus"></i> Assign Teachers
        </a>
      </div>
      <div class="card-body">
        @if($course->teachers->count() > 0)
        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="table-light">
              <tr>
                <th class="text-nowrap">#</th>
                <th class="text-nowrap">Teacher Name</th>
                <th class="text-nowrap">Specialization</th>
                <th class="text-nowrap">Role</th>
                <th class="text-nowrap">Primary Teacher</th>
                <th class="text-nowrap">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($course->teachers as $teacher)
              <tr>
                <td class="text-nowrap">{{ $loop->iteration }}</td>
                <td class="text-nowrap">{{ $teacher->name }}</td>
                <td class="text-nowrap">{{ $teacher->specialization ?? 'N/A' }}</td>
                <td class="text-nowrap">{{ $teacher->pivot->role ?? 'N/A' }}</td>
                <td class="text-nowrap">
                  @if($teacher->pivot->is_primary)
                    <span class="badge bg-success text-nowrap">Primary Teacher</span>
                  @else
                    <span class="badge bg-secondary text-nowrap">Secondary Teacher</span>
                  @endif
                </td>
                <td class="text-nowrap">
                  <a href="{{ url('/teachers/' . $teacher->id) }}" class="btn btn-sm btn-info text-nowrap">
                    <i class="bi bi-eye"></i> View Details
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @else
        <div class="alert alert-info text-nowrap">
          This course is not assigned to any teachers.
        </div>
        @endif
      </div>
    </div>
    
    @if($course->batches && $course->batches->count() > 0)
    <div class="card mb-4">
      <div class="card-header bg-success text-white">
        <h5 class="mb-0 text-nowrap">Class List</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="table-light">
              <tr>
                <th class="text-nowrap">#</th>
                <th class="text-nowrap">Class Name</th>
                <th class="text-nowrap">Start Date</th>
                <th class="text-nowrap">Number of Students</th>
                <th class="text-nowrap">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($course->batches as $batch)
              <tr>
                <td class="text-nowrap">{{ $loop->iteration }}</td>
                <td class="text-nowrap">{{ $batch->name }}</td>
                <td class="text-nowrap">{{ date('d-m-Y', strtotime($batch->start_date)) }}</td>
                <td class="text-nowrap">{{ $batch->enrollments->count() }}</td>
                <td class="text-nowrap">
                  <a href="{{ url('/batches/' . $batch->id) }}" class="btn btn-sm btn-info text-nowrap">
                    <i class="bi bi-eye"></i> View Details
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    @endif
    
    <div class="d-flex gap-2 flex-wrap">
      <a href="{{ url('/courses') }}" class="btn btn-secondary text-nowrap">
        <i class="bi bi-arrow-left"></i> Back
      </a>
      <a href="{{ url('/courses/' . $course->id . '/edit') }}" class="btn btn-primary text-nowrap">
        <i class="bi bi-pencil-square"></i> Edit
      </a>
      <a href="{{ url('/batches/create?course_id=' . $course->id) }}" class="btn btn-success text-nowrap">
        <i class="bi bi-plus-circle"></i> Add Class
      </a>
      <a href="{{ route('courses.assign.teachers.form', $course->id) }}" class="btn btn-info text-nowrap">
        <i class="bi bi-person-plus"></i> Assign Teachers
      </a>
    </div>
  </div>
</div>

@endsection