<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Animate.css for Bootstrap Animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Student Management System</title>
</head>
<body>
    <!-- Theme Toggle Button -->
    <div class="theme-toggle" id="themeToggle" title="Toggle dark/light mode">
        <i class="bi bi-moon fs-4"></i>
    </div>
    
    <!-- Toast Notification -->
    <div class="toast-container">
        <div id="mainToast" class="toast align-items-center text-white border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body bg-primary rounded-start">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    Welcome to Student Management System!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="sidebar animate__animated animate__fadeInLeft">
        <div class="text-center mb-4">
            <img src="{{ asset('img/phenikaa.png') }}" alt="Phenikaa Logo" class="mb-3" width="100" height="100">
            <h5 class="fw-bold sidebar-title">Student Management</h5>
        </div>
        <a class="active" href="#home"><i class="bi bi-house-door"></i> Dashboard</a>
        <a href="{{ url('/students') }}"><i class="bi bi-people"></i> Students</a>
        <a href="{{ url('/teachers') }}"><i class="bi bi-person-video3"></i> Teachers</a>
        <a href="{{ url('/courses') }}"><i class="bi bi-book"></i> Courses</a>
        <a href="{{ url('/batches') }}"><i class="bi bi-calendar3"></i> Batches</a>
        <a href="{{ url('/enrollments') }}"><i class="bi bi-person-check"></i> Enrollments</a>
        <a href="{{ url('/payments') }}"><i class="bi bi-credit-card"></i> Payments</a>
    </div>
    
    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-expand-lg navbar-light animate__animated animate__fadeInDown">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#">
                            <i class="bi bi-mortarboard-fill me-2"></i>
                            Student Management System
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">
                                        <i class="bi bi-box-arrow-in-right me-1"></i> Đăng nhập
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">
                                        <i class="bi bi-person-plus me-1"></i> Đăng ký
                                    </a>
                                </li>
                                @else
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Hồ sơ</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Cài đặt</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                                @endguest
                                <li class="nav-item ms-2">
                                    <a class="nav-link position-relative" href="#">
                                        <i class="bi bi-bell fs-5"></i>
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            3
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="content-wrapper">
                    <div class="fade-in">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js for analytics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>