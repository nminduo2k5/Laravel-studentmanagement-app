@extends('layout')
@section('content')
<div class="card">
    <div class="card-header">Thêm Widget Dashboard</div>
    <div class="card-body">
        <form action="{{ url('dashboard') }}" method="post">
            {!! csrf_field() !!}
            <div class="form-group mb-3">
                <label for="title">Tiêu đề</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="type">Loại Widget</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="card">Thẻ thống kê</option>
                    <option value="chart">Biểu đồ</option>
                    <option value="table">Bảng dữ liệu</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="content">Nội dung</label>
                <textarea name="content" id="content" class="form-control" rows="5"></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="order">Thứ tự hiển thị</label>
                <input type="number" name="order" id="order" class="form-control" value="0">
            </div>
            <div class="form-group mb-3">
                <label for="status">Trạng thái</label>
                <select name="status" id="status" class="form-control">
                    <option value="1">Hiển thị</option>
                    <option value="0">Ẩn</option>
                </select>
            </div>
            <input type="submit" value="Lưu" class="btn btn-success">
        </form>
    </div>
</div>
@endsection