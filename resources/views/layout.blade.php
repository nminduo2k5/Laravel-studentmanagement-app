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
    <title>Student Management System</title>
    <style>
        /* The side navigation menu */
.sidebar {
  margin: 0;
  padding: 0;
  width: 200px;
  background: linear-gradient(180deg, #e0eafc 0%, #cfdef3 100%);
  position: fixed;
  height: 100%;
  overflow: auto;
  box-shadow: 2px 0 8px rgba(0,0,0,0.05);
  border-right: 1px solid #d1d9e6;
}

/* Sidebar links */
.sidebar a {
  display: block;
  color: #22223b;
  padding: 16px;
  text-decoration: none;
  font-weight: 500;
  transition: background 0.3s, color 0.3s;
}

/* Active/current link */
.sidebar a.active {
  background-color: #04AA6D;
  color: white;
}

/* Links on mouse-over */
.sidebar a:hover:not(.active) {
  background-color: #555;
  color: white;
}

/* Page content. The value of the margin-left property should match the value of the sidebar's width property */
div.content {
  margin-left: 200px;
  padding: 1px 16px;
  height: 1000px;
}

/* On screens that are less than 700px wide, make the sidebar into a topbar */
@media screen and (max-width: 700px) {
  .sidebar {
    width: 100%;
    height: auto;
    position: relative;
  }
  .sidebar a {float: left;}
  div.content {margin-left: 0;}
}

/* On screens that are less than 400px, display the bar vertically, instead of horizontally */
@media screen and (max-width: 400px) {
  .sidebar a {
    text-align: center;
    float: none;
  }
}

body {
  background: linear-gradient(135deg, #f8fafc 0%, #e0eafc 100%);
  min-height: 100vh;
}

.theme-toggle {
            position: absolute;
            top: 20px;
            right: 30px;
            z-index: 1050;
            background: #fff;
            border-radius: 50%;
            border: 1px solid #d1d9e6;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            transition: background 0.3s;
        }
        .theme-toggle.dark {
            background: #22223b;
            color: #fff;
            border: 1px solid #555;
        }
        .toast-container {
            position: fixed;
            top: 80px;
            right: 30px;
            z-index: 2000;
        }
        body.dark-mode {
            background: linear-gradient(135deg, #232946 0%, #22223b 100%);
            color: #f4f4f4;
        }
        body.dark-mode .sidebar {
            background: linear-gradient(180deg, #232946 0%, #22223b 100%);
            color: #f4f4f4;
            border-right: 1px solid #232946;
        }
        body.dark-mode .sidebar a {
            color: #f4f4f4;
        }
        body.dark-mode .sidebar a.active {
            background-color: #04AA6D;
            color: #fff;
        }
        body.dark-mode .sidebar a:hover:not(.active) {
            background-color: #555;
            color: #fff;
        }
        body.dark-mode .navbar {
            background: #232946 !important;
        }
    </style>






</head>
<body>
    <!-- Theme Toggle Button -->
    <div class="theme-toggle" id="themeToggle" title="Toggle dark/light mode">
        <i class="bi bi-moon"></i>
    </div>
    <!-- Toast Notification -->
    <div class="toast-container">
        <div id="mainToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    Welcome to Student Management System!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <nav class="navbar navbar-expand-lg navbar-light bg-light animate__animated animate__fadeInDown">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#"><h2>Student Management Project</h2></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    </div>
                </div>
            </nav>
            </div> 
        </div>


        <div class="row">
            <div class="col-md-3">
                <!-- The sidebar -->
                <div class="sidebar animate__animated animate__fadeInLeft">
                    <a class="active" href="#home">Home</a>
                    <a href="{{ url('/students') }}">Student</a>
                    <a href="{{ url('/teachers') }}">Teacher</a>
                    <a href="{{ url('/courses') }}">Courses</a>
                    <a href="{{ url('/batches') }}">Batches</a>
                    <a href="{{ url('/enrollments') }}">Enrollments</a>
                    <a href="{{ url('/payment') }}">Payment</a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="animate__animated animate__fadeInUp">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Theme toggle logic
        const themeToggle = document.getElementById('themeToggle');
        const icon = themeToggle.querySelector('i');
        themeToggle.onclick = function() {
            document.body.classList.toggle('dark-mode');
            themeToggle.classList.toggle('dark');
            if(document.body.classList.contains('dark-mode')) {
                icon.classList.remove('bi-moon');
                icon.classList.add('bi-sun');
            } else {
                icon.classList.remove('bi-sun');
                icon.classList.add('bi-moon');
            }
        };
        // Show toast on load
        window.addEventListener('DOMContentLoaded', function() {
            var toastEl = document.getElementById('mainToast');
            var toast = new bootstrap.Toast(toastEl, { delay: 2500 });
            toast.show();
        });
    </script>
</body>
</html>