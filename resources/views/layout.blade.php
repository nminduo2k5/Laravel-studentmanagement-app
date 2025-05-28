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
    <title>Student Management System</title>
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --accent-color: #7209b7;
            --light-bg: #f8f9fa;
            --dark-bg: #212529;
            --border-radius: 10px;
            --box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            --transition: all 0.3s ease;
            --sidebar-width: 260px;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e0eafc 100%);
            min-height: 100vh;
            transition: var(--transition);
        }
        
        /* The side navigation menu */
        .sidebar {
            margin: 0;
            padding: 20px 0;
            width: var(--sidebar-width);
            background: #ffffff;
            position: fixed;
            height: 100%;
            overflow: auto;
            box-shadow: var(--box-shadow);
            border-right: 1px solid #eaeaea;
            border-radius: 0 var(--border-radius) var(--border-radius) 0;
            transition: var(--transition);
            z-index: 1030;
        }

        /* Sidebar links */
        .sidebar a {
            display: flex;
            align-items: center;
            color: #333;
            padding: 12px 20px;
            text-decoration: none;
            font-weight: 500;
            margin: 4px 8px;
            border-radius: var(--border-radius);
            transition: var(--transition);
        }
        
        .sidebar a i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        /* Active/current link */
        .sidebar a.active {
            background-color: var(--primary-color);
            color: white;
        }

        /* Links on mouse-over */
        .sidebar a:hover:not(.active) {
            background-color: #f1f5fe;
            color: var(--primary-color);
        }

        /* Page content */
        div.content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            min-height: 100vh;
        }
        
        /* Custom card styles */
        .stat-card {
            border-radius: var(--border-radius);
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            border-left: 5px solid var(--primary-color);
            background: white;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card .stat-icon {
            font-size: 2.5rem;
            opacity: 0.8;
        }
        
        .stat-card .stat-number {
            font-size: 2rem;
            font-weight: 700;
        }
        
        .stat-card .stat-title {
            font-size: 1rem;
            color: #6c757d;
            font-weight: 500;
        }

        /* Responsive layout */
        @media screen and (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                margin-bottom: 20px;
            }
            .sidebar a {
                float: left;
            }
            div.content {
                margin-left: 0;
            }
            .navbar-brand {
                margin-left: 0 !important;
            }
        }

        @media screen and (max-width: 576px) {
            .sidebar a {
                text-align: center;
                float: none;
                display: block;
            }
        }

        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 30px;
            z-index: 1050;
            background: #fff;
            border-radius: 50%;
            border: none;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
        }
        
        .theme-toggle.dark {
            background: #333;
            color: #fff;
        }
        
        .toast-container {
            position: fixed;
            top: 80px;
            right: 30px;
            z-index: 2000;
        }
        
        .card {
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            border: none;
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }
        
        .navbar {
            background: #fff !important;
            box-shadow: var(--box-shadow);
            border-radius: var(--border-radius);
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
            margin-left: 260px;
            font-size: 1.5rem;
            letter-spacing: 0.5px;
            position: relative;
            padding-bottom: 5px;
        }
        
        .navbar-brand::after {
            content: '';
            position: absolute;
            width: 40%;
            height: 3px;
            background: var(--primary-color);
            bottom: 0;
            left: 0;
            border-radius: 5px;
        }
        
        /* Dark mode styles */
        body.dark-mode {
            background: linear-gradient(135deg, #232946 0%, #121629 100%);
            color: #f4f4f4;
        }
        
        body.dark-mode .sidebar {
            background: #1a1a2e;
            border-right: 1px solid #333;
        }
        
        body.dark-mode .sidebar a {
            color: #f4f4f4;
        }
        
        body.dark-mode .sidebar a.active {
            background-color: var(--primary-color);
            color: #fff;
        }
        
        body.dark-mode .sidebar a:hover:not(.active) {
            background-color: #2a2a3a;
            color: var(--success-color);
        }
        
        body.dark-mode .navbar {
            background: #1a1a2e !important;
            color: #f4f4f4;
        }
        
        body.dark-mode .card {
            background: #1a1a2e;
            color: #f4f4f4;
        }
        
        body.dark-mode .navbar-brand {
            color: var(--success-color) !important;
        }
        
        body.dark-mode .text-dark {
            color: #f4f4f4 !important;
        }
        
        body.dark-mode .bg-light {
            background-color: #1a1a2e !important;
        }
        
        /* Animation for content */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .content-wrapper {
            margin-left: var(--sidebar-width);
            padding: 20px;
        }
    </style>
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
            <h5 class="fw-bold">Student Management</h5>
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
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-person-circle me-1"></i> Admin
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                                    </ul>
                                </li>
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
    <script>
        // Theme toggle logic with localStorage to remember preference
        const themeToggle = document.getElementById('themeToggle');
        const icon = themeToggle.querySelector('i');
        
        // Check for saved theme preference
        if (localStorage.getItem('darkMode') === 'true') {
            document.body.classList.add('dark-mode');
            themeToggle.classList.add('dark');
            icon.classList.remove('bi-moon');
            icon.classList.add('bi-sun');
        }
        
        themeToggle.onclick = function() {
            document.body.classList.toggle('dark-mode');
            themeToggle.classList.toggle('dark');
            
            if(document.body.classList.contains('dark-mode')) {
                icon.classList.remove('bi-moon');
                icon.classList.add('bi-sun');
                localStorage.setItem('darkMode', 'true');
            } else {
                icon.classList.remove('bi-sun');
                icon.classList.add('bi-moon');
                localStorage.setItem('darkMode', 'false');
            }
        };
        
        // Show toast on load with animation
        window.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var toastEl = document.getElementById('mainToast');
                var toast = new bootstrap.Toast(toastEl, { delay: 3000 });
                toast.show();
            }, 500);
            
            // Add active class to current page in sidebar
            const currentLocation = window.location.pathname;
            const sidebarLinks = document.querySelectorAll('.sidebar a');
            
            sidebarLinks.forEach(link => {
                if (link.getAttribute('href') === currentLocation) {
                    link.classList.add('active');
                    document.querySelectorAll('.sidebar a.active').forEach(activeLink => {
                        if (activeLink !== link) activeLink.classList.remove('active');
                    });
                }
            });
        });
    </script>
</body>
</html>