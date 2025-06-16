@extends('layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-person-check me-2"></i>Enrollments</h5>
                    <a href="{{ url('/enrollments/create') }}" class="btn btn-success btn-sm" title="Add New Enrollment">
                        <i class="bi bi-plus-circle me-1"></i> Add New
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">#</th>
                                    <th class="text-nowrap">Enrollment No</th>
                                    <th class="text-nowrap">Student</th>
                                    <th class="text-nowrap">Course</th>
                                    <th class="text-nowrap">Batch</th>
                                    <th class="text-nowrap">Join Date</th>
                                    <th class="text-nowrap">Fee</th>
                                    <th class="text-nowrap">Grades</th>
                                    <th class="text-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($enrollments as $item)
                                <tr>
                                    <td class="text-nowrap">{{ $loop->iteration }}</td>
                                    <td class="text-nowrap">{{ $item->enroll_no }}</td>
                                    <td class="text-nowrap">{{ $item->student->name ?? 'N/A' }}</td>
                                    <td class="text-nowrap">{{ $item->batch->course->name ?? 'N/A' }}</td>
                                    <td class="text-nowrap">{{ $item->batch->name ?? 'N/A' }}</td>
                                    <td class="text-nowrap">{{ date('d-m-Y', strtotime($item->join_date)) }}</td>
                                    <td class="text-nowrap">{{ number_format($item->fees, 0) }}</td>
                                    <td class="text-nowrap">
                                        @if(isset($item->total_grade))
                                            <span class="badge bg-{{ $item->total_grade >= 8.5 ? 'success' : ($item->total_grade >= 7.0 ? 'primary' : ($item->total_grade >= 5.5 ? 'info' : ($item->total_grade >= 4.0 ? 'warning' : 'danger'))) }} px-3 py-2">
                                                {{ number_format($item->total_grade, 1) }}
                                                <small>({{ $item->getGradeStatus() }})</small>
                                            </span>
                                        @else
                                            <span class="badge bg-secondary px-3 py-2">Chưa có điểm</span>
                                        @endif
                                    </td>
                                    <td class="text-nowrap">
                                        <div class="btn-group" role="group">
                                            <a href="{{ url('/enrollments/' . $item->id) }}" title="View Enrollment" class="btn btn-info btn-sm">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ url('/enrollments/' . $item->id . '/edit') }}" title="Edit Enrollment" class="btn btn-primary btn-sm">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a href="{{ route('enrollments.grades.form', $item->id) }}" title="Enter Grades" class="btn btn-warning btn-sm">
                                                <i class="bi bi-journal-check"></i>
                                            </a>
                                            <form method="POST" action="{{ url('/enrollments' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Enrollment" onclick="return confirm('Confirm delete?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection