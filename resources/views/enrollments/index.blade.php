@extends('layout')
@section('content')
<div class="card">
    <div class="card-header">
        <h2>Enrollment Management</h2>
    </div>
    <div class="card-body">
        <a href="{{ url('/enrollments/create') }}" class="btn btn-success btn-sm" title="Add New Enrollment">
            <i class="bi bi-plus-circle" aria-hidden="true"></i> Add New
        </a>
        <br/>
        <br/>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Enrollment No</th>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Batch</th>
                        <th>Join Date</th>
                        <th>Fees</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($enrollments as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->enroll_no }}</td>
                        <td>{{ $item->student ? $item->student->name : 'N/A' }}</td>
                        <td>{{ $item->batch && $item->batch->course ? $item->batch->course->name : 'N/A' }}</td>
                        <td>{{ $item->batch ? $item->batch->name : 'N/A' }}</td>
                        <td>{{ date('d-m-Y', strtotime($item->join_date)) }}</td>
                        <td>{{ number_format($item->fees, 2) }}</td>
                        <td>
                            <a href="{{ url('/enrollments/' . $item->id) }}" title="View Enrollment"><button class="btn btn-info btn-sm"><i class="bi bi-eye" aria-hidden="true"></i> View</button></a>
                            <a href="{{ url('/enrollments/' . $item->id . '/edit') }}" title="Edit Enrollment"><button class="btn btn-primary btn-sm"><i class="bi bi-pencil-square" aria-hidden="true"></i> Edit</button></a>
                            <form method="POST" action="{{ url('/enrollments' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Enrollment" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="bi bi-trash" aria-hidden="true"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection