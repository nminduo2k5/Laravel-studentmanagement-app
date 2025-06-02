@extends('layout')
@section('content')
<div class="card">
    <div class="card-header">Chỉnh sửa Widget Dashboard</div>
    <div class="card-body">
        <form action="{{ url('dashboard/' . $widget->id) }}" method="post">
            {!! csrf_field() !!}
            @method("PATCH")
            <input type="hidden" name="id" value="{{ $widget->id }}" />
            <div class="form-group mb-3">
                <label for="title">Tiêu đề</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ $widget->title }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="type">Loại Widget</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="card" {{ $widget->type == 'card' ? 'selected' : '' }}>Thẻ thống kê</option>
                    <option value="chart" {{ $widget->type == 'chart' ? 'selected' : '' }}>Biểu đồ</option>
                    <option value="table" {{ $widget->type == 'table' ? 'selected' : '' }}>Bảng dữ liệu</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="content">Nội dung</label>
                <textarea name="content" id="content" class="form-control" rows="5">{{ $widget->content }}</textarea>
            </div>
            <div class="form-group mb-3">
                <label for="order">Thứ tự hiển thị</label>
                <input type="number" name="order" id="order" class="form-control" value="{{ $widget->order }}">
            </div>
            <div class="form-group mb-3">
                <label for="status">Trạng thái</label>
                <select name="status" id="status" class="form-control">
                    <option value="1" {{ $widget->status == 1 ? 'selected' : '' }}>Hiển thị</option>
                    <option value="0" {{ $widget->status == 0 ? 'selected' : '' }}>Ẩn</option>
                </select>
            </div>
            <input type="submit" value="Cập nhật" class="btn btn-success">
        </form>
    </div>
</div>
@endsection