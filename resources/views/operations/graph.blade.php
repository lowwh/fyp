@extends('layouts.app')

@section('content')
<style>
    .flex-container {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 30px;
        margin-top: 50px;
        margin-bottom: 50px;
    }

    .flex-container2 {
        display: flex;
        justify-content: center;
        margin-top: 50px;
    }

    .stat-card {
        background-color: #f0f0f0;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        text-align: center;
        width: 200px;
    }

    .stat-card h3 {
        margin: 0;
        font-size: 18px;
    }

    .stat-card p {
        margin: 10px 0 0;
        font-size: 24px;
        font-weight: bold;
    }

    .filters-container,
    .search-notification-bar {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 20px 0;
    }

    .filters-container input,
    .search-notification-bar input {
        margin-right: 10px;
        padding: 5px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    .export-data,
    .apply-filters {
        padding: 5px 10px;
        margin-left: 5px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .announcement-bar {
        background-color: #e7f4ff;
        padding: 10px;
        text-align: center;
        margin-bottom: 20px;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .data-table {
        width: 80%;
        margin: 20px auto;
        border-collapse: collapse;
    }

    .data-table th,
    .data-table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    .data-table th {
        background-color: #f4f4f4;
    }

    .help-section {
        text-align: center;
        margin-top: 30px;
    }

    .help-section button {
        padding: 10px 20px;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
</style>

<!-- <div class="announcement-bar">
    <p>New feature release: Real-time data filtering now available!</p>
</div> -->

<div class="summary-container">
    @can('isUser')
        <div class="flex-container">
            <div class="stat-card">
                <h3>Total Users</h3>
                <p>{{ $totalUsers }}</p>
            </div>
            <div class="stat-card">
                <h3>Completed Projects</h3>
                <p>{{ $usercompletedProjects }}</p>
            </div>
            <div class="stat-card">
                <h3>Pending Projects</h3>
                <p>{{ $userpendingProjects }}</p>
            </div>
            <div class="stat-card">
                <h3>Rejected Projects</h3>
                <p>{{ $userrejectedProjects }}</p>
            </div>
        </div>
    @endcan
    @can('isFreelancer')
        <div class="flex-container">
            <div class="stat-card">
                <h3>Total Users</h3>
                <p>{{ $totalUsers }}</p>
            </div>
            <div class="stat-card">
                <h3>Completed Projects</h3>
                <p>{{ $freelancercompletedProjects }}</p>
            </div>
            <div class="stat-card">
                <h3>Pending Projects</h3>
                <p>{{ $freelancerpendingProjects }}</p>
            </div>
            <div class="stat-card">
                <h3>Rejected Projects</h3>
                <p>{{ $freelancerrejectedProjects }}</p>
            </div>
        </div>
    @endcan
</div>

<!-- <div class="filters-container">
    <label for="date-range">Select Date Range:</label>
    <input type="date" id="start-date"> to
    <input type="date" id="end-date">
    <button class="apply-filters">Apply</button>
    <button class="export-data">Export as CSV</button>
</div> -->

<!-- <div class="search-notification-bar">
    <input type="text" placeholder="Search...">
    <i class="notification-bell-icon"></i>
</div> -->

<div class="flex-container">
    <div class="chart-container1" style="position: relative; height: 400px; width:600px;">
        <canvas id="ratingsChart"></canvas>
    </div>
    <!-- <div class="chart-container2" style="position: relative; height: 400px;width:400px;">
        <canvas id="pieChart"></canvas>
    </div> -->
</div>

<div class="flex-container2">
    <div class="chart-container" style="position: relative; height:400px; width:1000px;">
        <canvas id="barChartData"></canvas>
    </div>
</div>

<!-- <table class="data-table">
    <thead>
        <tr>
            <th>Date</th>
            <th>Status</th>
            <th>User Count</th>
            <th>Actions</th>
        </tr>
    </thead>

</table>

<div class="help-section">
    <button onclick="openHelpModal()">Help & Support</button>
</div> -->

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx1 = document.getElementById('ratingsChart').getContext('2d');
        // const ctx2 = document.getElementById('pieChart').getContext('2d');
        const ctx3 = document.getElementById('barChartData').getContext('2d');

        // Data for the charts
        const chartData = @json($chartData);
        // const pieChartData = @json($pieChartData);
        const barChartData = @json($barChartData);

        // Ratings bar chart
        new Chart(ctx1, {
            type: 'bar',
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: { display: true, text: 'Status', font: { size: 16 } },
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Count', font: { size: 16 } },
                        ticks: { stepSize: 1, color: '#333' },
                        grid: { color: '#e3e3e3' }
                    }
                },
                plugins: {
                    legend: { display: true, position: 'top', labels: { usePointStyle: true, font: { size: 14 } } },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return `${context.dataset.label}: ${context.raw}`;
                            }
                        }
                    }
                },
                animation: { duration: 1000, easing: 'easeOutBounce' }
            }
        });

        // // Pie chart
        // new Chart(ctx2, {
        //     type: 'pie',
        //     data: pieChartData,
        //     options: {
        //         responsive: true,
        //         maintainAspectRatio: false,
        //         plugins: {
        //             legend: { display: true, position: 'top', labels: { usePointStyle: true, font: { size: 14 } } },
        //             tooltip: {
        //                 callbacks: {
        //                     label: function (context) {
        //                         return `${context.label}: ${context.raw}`;
        //                     }
        //                 }
        //             }
        //         },
        //         animation: { duration: 1000, easing: 'easeOutBounce' }
        //     }
        // });

        // Bar chart
        new Chart(ctx3, {
            type: 'bar',
            data: barChartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: { display: true, text: 'Date', font: { size: 16 } },
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Count', font: { size: 16 } },
                        ticks: { stepSize: 1, color: '#333' },
                        grid: { color: '#e3e3e3' }
                    }
                },
                plugins: {
                    legend: { display: true, position: 'top', labels: { usePointStyle: true, font: { size: 14 } } },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return `${context.dataset.label}: ${context.raw}`;
                            }
                        }
                    }
                },
                animation: { duration: 1000, easing: 'easeOutBounce' }
            }
        });
    });

    function openHelpModal() {
        alert('Help section will be available soon!');
    }
</script>
@endsection