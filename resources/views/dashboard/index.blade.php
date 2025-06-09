@extends('layout')
@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="mb-4">Dashboard</h2>
            
            <div class="row">
                <!-- Students Card -->
                <div class="col-md-4 mb-4">
                    <div class="card stat-card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="stat-title">Students</h5>
                                <h2 class="stat-number">{{ $studentCount }}</h2>
                            </div>
                            <div class="stat-icon text-primary">
                                <i class="bi bi-people-fill"></i>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="{{ url('/students') }}" class="btn btn-sm btn-outline-primary">View Details</a>
                        </div>
                    </div>
                </div>
                
                <!-- Teachers Card -->
                <div class="col-md-4 mb-4">
                    <div class="card stat-card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="stat-title">Teachers</h5>
                                <h2 class="stat-number">{{ $teacherCount }}</h2>
                            </div>
                            <div class="stat-icon text-success">
                                <i class="bi bi-person-video3"></i>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="{{ url('/teachers') }}" class="btn btn-sm btn-outline-success">View Details</a>
                        </div>
                    </div>
                </div>
                
                <!-- Courses Card -->
                <div class="col-md-4 mb-4">
                    <div class="card stat-card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="stat-title">Courses</h5>
                                <h2 class="stat-number">{{ $courseCount }}</h2>
                            </div>
                            <div class="stat-icon text-info">
                                <i class="bi bi-book-fill"></i>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="{{ url('/courses') }}" class="btn btn-sm btn-outline-info">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <!-- Batches Card -->
                <div class="col-md-4 mb-4">
                    <div class="card stat-card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="stat-title">Classes</h5>
                                <h2 class="stat-number">{{ $batchCount }}</h2>
                            </div>
                            <div class="stat-icon text-warning">
                                <i class="bi bi-calendar3-fill"></i>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="{{ url('/batches') }}" class="btn btn-sm btn-outline-warning">View Details</a>
                        </div>
                    </div>
                </div>
                
                <!-- Enrollments Card -->
                <div class="col-md-4 mb-4">
                    <div class="card stat-card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="stat-title">Enrollments</h5>
                                <h2 class="stat-number">{{ $enrollmentCount }}</h2>
                            </div>
                            <div class="stat-icon text-danger">
                                <i class="bi bi-person-check-fill"></i>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="{{ url('/enrollments') }}" class="btn btn-sm btn-outline-danger">View Details</a>
                        </div>
                    </div>
                </div>
                
                <!-- Payments Card -->
                <div class="col-md-4 mb-4">
                    <div class="card stat-card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="stat-title">Payments</h5>
                                <h2 class="stat-number">{{ $paymentCount }}</h2>
                            </div>
                            <div class="stat-icon text-secondary">
                                <i class="bi bi-credit-card-fill"></i>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="{{ url('/payments') }}" class="btn btn-sm btn-outline-secondary">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Revenue Overview -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Total Payments</h5>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h3>Total Revenue: {{ number_format($totalRevenue, 0, ',', '.') }} VNĐ</h3>
                                    <p class="text-muted">Total Payments: {{ $paymentCount }}</p>
                                </div>
                                <div class="col-md-6">
                                    <canvas id="revenueChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activities -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Recent Activities</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="bi bi-person-plus text-primary me-2"></i>
                                        New student added
                                    </div>
                                    <span class="badge bg-primary rounded-pill">Today</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="bi bi-cash-coin text-success me-2"></i>
                                        New payment recorded
                                    </div>
                                    <span class="badge bg-success rounded-pill">Yesterday</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="bi bi-book text-info me-2"></i>
                                        new course created
                                    </div>
                                    <span class="badge bg-info rounded-pill">3 ngày trước</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue Chart
    var ctx = document.getElementById('revenueChart').getContext('2d');
    var revenueChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June'],
            datasets: [{
                label: 'Revenue (VNĐ)',
                data: [{{ $totalRevenue/6 }}, {{ $totalRevenue/5 }}, {{ $totalRevenue/4 }}, {{ $totalRevenue/3 }}, {{ $totalRevenue/2 }}, {{ $totalRevenue }}],
                backgroundColor: [
                    'rgba(67, 97, 238, 0.2)',
                    'rgba(67, 97, 238, 0.3)',
                    'rgba(67, 97, 238, 0.4)',
                    'rgba(67, 97, 238, 0.5)',
                    'rgba(67, 97, 238, 0.6)',
                    'rgba(67, 97, 238, 0.7)'
                ],
                borderColor: [
                    'rgba(67, 97, 238, 1)',
                    'rgba(67, 97, 238, 1)',
                    'rgba(67, 97, 238, 1)',
                    'rgba(67, 97, 238, 1)',
                    'rgba(67, 97, 238, 1)',
                    'rgba(67, 97, 238, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
@endsection