@extends('layout')
@section('content')

<div class="card">
  <div class="card-header">
    <h4>Assign Teachers to Course: {{ $course->name }}</h4>
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
    
    <form action="{{ route('courses.assign.teachers', $course->id) }}" method="post">
      @csrf
      
      <div class="mb-4">
        <h5>Course Information</h5>
        <p><strong>Course Name:</strong> {{ $course->name }}</p>
        <p><strong>Syllabus:</strong> {{ $course->syllabus }}</p>
        <p><strong>Duration:</strong> {{ $course->duration() }}</p>
      </div>
      
      <div class="mb-4">
        <h5>Select Teachers</h5>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead class="table-light">
              <tr>
                <th>Select</th>
                <th>Primary Teacher</th>
                <th>Teacher Name</th>
                <th>Specialization</th>
                <th>Role in Course</th>
              </tr>
            </thead>
            <tbody>
              @foreach($teachers as $teacher)
              <tr>
                <td class="text-center">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="teacher_ids[]" value="{{ $teacher->id }}" id="teacher{{ $teacher->id }}" 
                      {{ in_array($teacher->id, $assignedTeachers) ? 'checked' : '' }}>
                  </div>
                </td>
                <td class="text-center">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="primary_teacher_id" value="{{ $teacher->id }}" id="primary{{ $teacher->id }}"
                      {{ $primaryTeacher && $primaryTeacher->id == $teacher->id ? 'checked' : '' }}>
                  </div>
                </td>
                <td>{{ $teacher->name }}</td>
                <td>{{ $teacher->specialization ?? 'N/A' }}</td>
                <td>
                  <select name="roles[{{ $teacher->id }}]" class="form-control">
                    <option value="">Select role</option>
                    <option value="Main Lecturer" {{ $course->teachers->where('id', $teacher->id)->first() && $course->teachers->where('id', $teacher->id)->first()->pivot->role == 'Main Lecturer' ? 'selected' : '' }}>Main Lecturer</option>
                    <option value="Co-Lecturer" {{ $course->teachers->where('id', $teacher->id)->first() && $course->teachers->where('id', $teacher->id)->first()->pivot->role == 'Co-Lecturer' ? 'selected' : '' }}>Co-Lecturer</option>
                    <option value="Teaching Assistant" {{ $course->teachers->where('id', $teacher->id)->first() && $course->teachers->where('id', $teacher->id)->first()->pivot->role == 'Teaching Assistant' ? 'selected' : '' }}>Teaching Assistant</option>
                  </select>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      
      <div class="d-flex gap-2">
        <a href="{{ url('/courses/' . $course->id) }}" class="btn btn-secondary">
          <i class="bi bi-arrow-left"></i> Back
        </a>
        <button type="submit" class="btn btn-primary">
          <i class="bi bi-save"></i> Save Changes
        </button>
      </div>
    </form>
  </div>
</div>

@endsection