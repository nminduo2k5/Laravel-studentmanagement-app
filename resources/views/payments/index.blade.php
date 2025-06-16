@extends('layout')
@section('content')
<div class="card">
    <div class="card-header">
        <h2>Payments Management</h2>
    </div>
    <div class="card-body">
        <a href="{{ url('/payments/create') }}" class="btn btn-success btn-sm" title="Add New Payment">
            <i class="bi bi-plus-circle" aria-hidden="true"></i> Add New
        </a>
        <br/>
        <br/>
        <div class="table-responsive">
            <table class="table ">
                <thead>
                    <tr>
                        <th class="text-nowrap">#</th>
                        <th class="text-nowrap">Student</th>
                        <th class="text-nowrap">Course</th>
                        <th class="text-nowrap">Batch</th>
                        <th class="text-nowrap">Payment Date</th>
                        <th class="text-nowrap">Amount</th>
                        <th class="text-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($payments as $item)
                    <tr>
                        <td class="text-nowrap">{{ $loop->iteration }}</td>
                        <td class="text-nowrap">{{ $item->enrollment && $item->enrollment->student ? $item->enrollment->student->name : 'N/A' }}</td>
                        <td class="text-nowrap">{{ $item->enrollment && $item->enrollment->batch && $item->enrollment->batch->course ? $item->enrollment->batch->course->name : 'N/A' }}</td>
                        <td class="text-nowrap">{{ $item->enrollment && $item->enrollment->batch ? $item->enrollment->batch->name : 'N/A' }}</td>
                        <td class="text-nowrap">{{ date('d-m-Y', strtotime($item->payment_date)) }}</td>
                        <td class="text-nowrap">{{ number_format($item->amount, 2) }}</td>
                        <td class="text-nowrap">
                            <a href="{{ url('/payments/' . $item->id) }}" title="View Payment"><button class="btn btn-info btn-sm"><i class="bi bi-eye"></i> View</button></a>
                            <a href="{{ url('/payments/' . $item->id . '/edit') }}" title="Edit Payment"><button class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</button></a>
                            <form method="POST" action="{{ url('/payments' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Payment" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="bi bi-trash"></i> Delete</button>
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