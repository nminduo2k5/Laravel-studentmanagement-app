<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <title>Student Management System</title>
    <style>
        body {
            min-height: 100vh;
            /* Gradient tím hồng - xanh cyan hiện đại */
            background: linear-gradient(120deg, #a18cd1 0%, #fbc2eb 50%, #5eead4 100%);
            font-family: 'Montserrat', Arial, sans-serif;
            animation: fadeInBody 1s;
        }
        @keyframes fadeInBody {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .navbar {
            border-radius: 16px;
            margin-top: 24px;
            box-shadow: 0 4px 24px rgba(44, 62, 80, 0.08);
            background:  #a18cd1;
        }
        .navbar-brand h2 {
            font-weight: 600;
            color: #2d3436;
            margin-left:360px;
            letter-spacing: 1px;
        }
        .sidebar {
            margin: 0;
            padding: 0;
            width: 220px;
            /* Màu sidebar giống màu content */
            background: 
                linear-gradient(135deg, rgba(161,140,209,0.13) 0%, rgba(94,234,212,0.13) 100%),
                rgba(255,255,255,0.55);
            position: fixed;
            height: 90vh;
            top: 80px;
            left: -250px;
            border-radius: 18px;
            box-shadow: 0 8px 32px 0 rgba(161, 140, 209, 0.08);
            overflow: auto;
            transition: left 0.7s cubic-bezier(.68,-0.55,.27,1.55);
            animation: slideInSidebar 1s forwards;
        }
        @keyframes slideInSidebar {
            to { left: 40px; }
        }
        .sidebar a {
            display: block;
            color: #6d4e9e;
            padding: 18px 28px;
            text-decoration: none;
            font-size: 1.1rem;
            border-radius: 12px;
            margin: 8px 12px;
            transition: background 0.3s, color 0.3s, transform 0.2s;
            opacity: 0;
            transform: translateX(-30px);
            animation: fadeInLink 0.7s forwards;
        }
        .sidebar a:nth-child(1) { animation-delay: 0.5s; }
        .sidebar a:nth-child(2) { animation-delay: 0.6s; }
        .sidebar a:nth-child(3) { animation-delay: 0.7s; }
        .sidebar a:nth-child(4) { animation-delay: 0.8s; }
        .sidebar a:nth-child(5) { animation-delay: 0.9s; }
        .sidebar a:nth-child(6) { animation-delay: 1.0s; }
        .sidebar a:nth-child(7) { animation-delay: 1.1s; }
        @keyframes fadeInLink {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        .sidebar a.active, .sidebar a:hover {
            /* Gradient tím hồng - cyan nhạt */
            background: linear-gradient(90deg, #a18cd1 0%, #fbc2eb 60%, #5eead4 100%);
            color: #fff;
            font-weight: 600;
            transform: scale(1.05);
            box-shadow: 0 2px 8px rgba(161, 140, 209, 0.13);
        }
        .content {
            margin-left: 50px; /* Sát sidebar hơn */
            margin-top: 10px;
            padding: 40px 36px;
            /* Gradient glassmorphism tím hồng - cyan nhạt */
            background: 
                linear-gradient(135deg, rgba(161,140,209,0.13) 0%, rgba(94,234,212,0.13) 100%),
                rgba(255,255,255,0.55);
            border-radius: 24px;
            min-height: 82vh;
            box-shadow: 0 12px 40px 0 rgba(161, 140, 209, 0.13), 0 1.5px 8px rgba(44, 62, 80, 0.08);
            animation: fadeInContent 1.2s;
            backdrop-filter: blur(16px) saturate(160%);
            -webkit-backdrop-filter: blur(16px) saturate(160%);
            border: 1.5px solid rgba(255,255,255,0.25);
            transition: box-shadow 0.3s, background 0.3s;
        }
        @keyframes fadeInContent {
            from { opacity: 0; transform: translateY(30px);}
            to { opacity: 1; transform: translateY(0);}
        }
        /* Card, box, panel, alert trong content */
        .content .card,
        .content .panel,
        .content .box,
        .content .alert,
        .content .info-box {
            background: linear-gradient(120deg, rgba(161,140,209,0.10) 0%, rgba(251,194,235,0.10) 50%, rgba(94,234,212,0.10) 100%), rgba(255,255,255,0.75);
            border-radius: 18px;
            box-shadow: 0 2px 12px 0 rgba(161, 140, 209, 0.08);
            border: 1px solid rgba(161,140,209,0.09);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            color: #4b3869;
        }
        .content .card-header,
        .content .panel-heading {
            background: transparent;
            border-bottom: 1px solid rgba(161,140,209,0.08);
            color: #6d4e9e;
            font-weight: 600;
        }
        .content .alert {
            border-left: 4px solid #a18cd1;
        }
        @media screen and (max-width: 900px) {
            .sidebar {
                position: static;
                width: 100%;
                height: auto;
                margin: 0 0 24px 0;
                left: 0;
                top: 0;
                border-radius: 16px;
                animation: none;
                transition: none;
            }
            .content {
                margin-left: 0;
                margin-top: 0;
                border-radius: 18px;
                padding: 24px 10px;
            }
        }
        @media screen and (max-width: 600px) {
            .sidebar a {
                padding: 14px 10px;
                font-size: 1rem;
                margin: 6px 6px;
            }
            .content {
                padding: 16px 6px;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#"><h2>Student Management Project</h2></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent"></div>
                    </div>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <div class="sidebar mt-3">
                    <a class="active" href="#home">Home</a>
                    <a href="{{ url('/students') }}">Student</a>
                    <a href="{{ url('/teachers') }}">Teacher</a>
                    <a href="{{ url('/courses') }}">Courses</a>
                    <a href="{{ url('/batches') }}">Batches</a>
                    <a href="{{ url('/enrollments') }}">Enrollments</a>
                    <a href="{{ url('/payment') }}">Payment</a>
                </div>
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="content mt-3">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</body>
</html>