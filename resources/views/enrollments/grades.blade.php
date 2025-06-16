@extends('layout')
@section('content')

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Grade for students</h4>
  </div>
  <div class="card-body">
    <div class="row mb-4">
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-header bg-info text-white">
            <h5 class="mb-0">Student Information</h5>
          </div>
          <div class="card-body">
            @if($enrollment->student)
              <div class="d-flex align-items-center mb-3">
                <div class="avatar-placeholder bg-light rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                  <i class="bi bi-person fs-3"></i>
                </div>
                <div>
                  <h5 class="mb-0">{{ $enrollment->student->name }}</h5>
                  <p class="text-muted mb-0">ID: {{ $enrollment->student->id }}</p>
                </div>
              </div>
              <hr>
              <div class="student-details">
                <p><i class="bi bi-envelope me-2"></i><strong>Email:</strong> {{ $enrollment->student->email ?? 'N/A' }}</p>
                <p><i class="bi bi-telephone me-2"></i><strong>Phone:</strong> {{ $enrollment->student->mobile ?? 'N/A' }}</p>
                <p><i class="bi bi-geo-alt me-2"></i><strong>Address:</strong> {{ $enrollment->student->address ?? 'N/A' }}</p>
                <p><i class="bi bi-calendar-date me-2"></i><strong>Date of Birth:</strong> 
                  {{ $enrollment->student->dateofbirth ? date('d-m-Y', strtotime($enrollment->student->dateofbirth)) : 'N/A' }}
                </p>
                <p><i class="bi bi-gender-ambiguous me-2"></i><strong>Gender:</strong> {{ $enrollment->student->gender ?? 'N/A' }}</p>
              </div>
            @else
              <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle me-2"></i> Student information not found
              </div>
            @endif
          </div>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-header bg-success text-white">
            <h5 class="mb-0">Course & Class Information</h5>
          </div>
          <div class="card-body">
            @if($enrollment->batch && $enrollment->batch->course)
              <h5 class="mb-3">{{ $enrollment->batch->course->name }}</h5>
              <hr>
              <div class="course-details mb-4">
                <p><i class="bi bi-book me-2"></i><strong>Course Code:</strong> {{ $enrollment->batch->course->code ?? 'N/A' }}</p>
                <p><i class="bi bi-clock me-2"></i><strong>Duration:</strong> {{ $enrollment->batch->course->duration() ?? 'N/A' }}</p>
                <p><i class="bi bi-cash-coin me-2"></i><strong>Price:</strong> {{ number_format($enrollment->batch->course->price ?? 0, 0) }} VND</p>
                <p><i class="bi bi-info-circle me-2"></i><strong>Description:</strong> {{ \Illuminate\Support\Str::limit($enrollment->batch->course->description ?? 'N/A', 100) }}</p>
              </div>

              <h6 class="mt-4 mb-3"><i class="bi bi-people me-2"></i>Class Information</h6>
              <div class="batch-details">
                <p><i class="bi bi-collection me-2"></i><strong>Class Name:</strong> {{ $enrollment->batch->name }}</p>
                <p><i class="bi bi-calendar-date me-2"></i><strong>Start Date:</strong> 
                  {{ date('d-m-Y', strtotime($enrollment->batch->start_date)) }}
                </p>
                <p><i class="bi bi-calendar-check me-2"></i><strong>End Date:</strong> 
                  {{ $enrollment->batch->end_date ? date('d-m-Y', strtotime($enrollment->batch->end_date)) : 'N/A' }}
                </p>
                <p><i class="bi bi-person-video3 me-2"></i><strong>Teacher:</strong> 
                  @if($enrollment->batch->teachers && $enrollment->batch->teachers->count() > 0)
                    {{ $enrollment->batch->teachers->pluck('name')->join(', ') }}
                  @else
                    Not Assigned
                  @endif
                </p>
              </div>
            @else
              <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle me-2"></i> Course information not found
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
    
    <div class="card">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Enter Grades</h5>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('enrollments.grades.save', $enrollment->id) }}">
          @csrf
          
          <div class="row mb-3">
            <div class="col-md-4">
              <div class="form-group">
                <label for="midterm_grade" class="form-label">Midterm Grade (30%)</label>
                <input type="number" name="midterm_grade" id="midterm_grade" class="form-control @error('midterm_grade') is-invalid @enderror" 
                       value="{{ old('midterm_grade', $enrollment->midterm_grade) }}" step="0.1" min="0" max="10">
                @error('midterm_grade')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="form-group">
                <label for="final_grade" class="form-label">Final Grade (50%)</label>
                <input type="number" name="final_grade" id="final_grade" class="form-control @error('final_grade') is-invalid @enderror" 
                       value="{{ old('final_grade', $enrollment->final_grade) }}" step="0.1" min="0" max="10">
                @error('final_grade')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="form-group">
                <label for="assignment_grade" class="form-label">Assignment Grade (20%)</label>
                <input type="number" name="assignment_grade" id="assignment_grade" class="form-control @error('assignment_grade') is-invalid @enderror" 
                       value="{{ old('assignment_grade', $enrollment->assignment_grade) }}" step="0.1" min="0" max="10">
                @error('assignment_grade')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
          
          <div class="card mb-4 border-info">
            <div class="card-header bg-info text-white">
              <h5 class="mb-0"><i class="bi bi-calculator me-2"></i>Calculate Grades</h5>
            </div>
            <div class="card-body">
              <div class="alert alert-light border">
                <div class="row">
                  <div class="col-md-4">
                    <div class="text-center">
                      <h6>Midterm Grade</h6>
                      <div class="display-6 fw-bold text-primary">
                        {{ isset($enrollment->midterm_grade) ? number_format($enrollment->midterm_grade, 1) : '?' }}
                      </div>
                      <small class="text-muted">× 30%</small>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="text-center">
                      <h6>Final Grade</h6>
                      <div class="display-6 fw-bold text-danger">
                        {{ isset($enrollment->final_grade) ? number_format($enrollment->final_grade, 1) : '?' }}
                      </div>
                      <small class="text-muted">× 50%</small>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="text-center">
                      <h6>Assignment Grade</h6>
                      <div class="display-6 fw-bold text-success">
                        {{ isset($enrollment->assignment_grade) ? number_format($enrollment->assignment_grade, 1) : '?' }}
                      </div>
                      <small class="text-muted">× 20%</small>
                    </div>
                  </div>
                </div>
                
                @if($enrollment->total_grade)
                <hr>
                <div class="row">
                  <div class="col-12 text-center">
                    <h5>Total Grade</h5>
                    <div class="display-5 fw-bold">{{ number_format($enrollment->total_grade, 2) }}</div>
                    <div class="badge bg-{{ $enrollment->total_grade >= 8.5 ? 'success' : ($enrollment->total_grade >= 7.0 ? 'primary' : ($enrollment->total_grade >= 5.5 ? 'info' : ($enrollment->total_grade >= 4.0 ? 'warning' : 'danger'))) }} mt-2 fs-6">
                      {{ $enrollment->getGradeStatus() }}
                    </div>
                  </div>
                </div>
                @endif
              </div>
              
              <div class="mt-3">
                <div class="card bg-light">
                  <div class="card-body p-3">
                    <h6 class="card-title">Grading Scale</h6>
                    <div class="row">
                      <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                          <li class="list-group-item d-flex justify-content-between align-items-center p-2">
                            Excellent
                            <span class="badge bg-success rounded-pill">8.5 - 10</span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center p-2">
                            Good
                            <span class="badge bg-primary rounded-pill">7.0 - 8.4</span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center p-2">
                            Fair
                            <span class="badge bg-info rounded-pill">5.5 - 6.9</span>
                          </li>
                        </ul>
                      </div>
                      <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                          <li class="list-group-item d-flex justify-content-between align-items-center p-2">
                            Average
                            <span class="badge bg-warning rounded-pill">4.0 - 5.4</span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center p-2">
                            Fail
                            <span class="badge bg-danger rounded-pill">0 - 3.9</span>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="form-group mb-3">
            <label for="grade_remarks" class="form-label">Teacher's Remarks</label>
            <textarea name="grade_remarks" id="grade_remarks" class="form-control @error('grade_remarks') is-invalid @enderror" 
                      rows="4" placeholder="Enter remarks about the student's learning process and results...">{{ old('grade_remarks', $enrollment->grade_remarks) }}</textarea>
            @error('grade_remarks')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          
          <div class="d-flex gap-2">
            <a href="{{ url('/enrollments/' . $enrollment->id) }}" class="btn btn-secondary">
              <i class="bi bi-arrow-left"></i> Back
            </a>
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-save"></i> Save Grades
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection