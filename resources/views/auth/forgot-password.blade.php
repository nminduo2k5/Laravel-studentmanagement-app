@extends('layout')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card mt-5">
            <div class="card-header"><h4>Quên mật khẩu</h4></div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Gửi link đặt lại mật khẩu</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="{{ route('login') }}">Quay lại đăng nhập</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection