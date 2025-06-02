@extends('layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4>Chi tiết Widget</h4>
                        <div>
                            <a href="{{ url('/dashboard/' . $widget->id . '/edit') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-pencil"></i> Chỉnh sửa
                            </a>
                            <form method="POST" action="{{ url('/dashboard' . '/' . $widget->id) }}" accept-charset="UTF-8" style="display:inline">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                    <i class="bi bi-trash"></i> Xóa
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="200">ID</th>
                                    <td>{{ $widget->id }}</td>
                                </tr>
                                <tr>
                                    <th>Tiêu đề</th>
                                    <td>{{ $widget->title }}</td>
                                </tr>
                                <tr>
                                    <th>Loại Widget</th>
                                    <td>
                                        @if($widget->type == 'card')
                                            Thẻ thống kê
                                        @elseif($widget->type == 'chart')
                                            Biểu đồ
                                        @elseif($widget->type == 'table')
                                            Bảng dữ liệu
                                        @else
                                            {{ $widget->type }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nội dung</th>
                                    <td>{{ $widget->content }}</td>
                                </tr>
                                <tr>
                                    <th>Thứ tự hiển thị</th>
                                    <td>{{ $widget->order }}</td>
                                </tr>
                                <tr>
                                    <th>Trạng thái</th>
                                    <td>{{ $widget->status == 1 ? 'Hiển thị' : 'Ẩn' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection