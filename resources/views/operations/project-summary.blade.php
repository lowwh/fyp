@extends('layouts.app')

@section('content')
<!-- No need for <html>, <head>, or <body> tags here -->

<style>
    .chart-container {
        width: 500px;
        /* Adjust width */
        height: 550px;
        /* Adjust height */
        margin: 20px auto;
        /* Center the charts */
    }
</style>

<h1>Charts View</h1>

@can('isUser')
    <!-- Pie Chart for User -->
    <div class="chart-container">
        <h2>Project Status Distribution (Pie Chart)</h2>
        <canvas id="myPieChartUser"></canvas>
    </div>
@endcan

@can('isFreelancer')
    <!-- Pie Chart for Freelancer -->
    <div class="chart-container">
        <h2>Project Status Distribution (Pie Chart)</h2>
        <canvas id="myPieChartFreelancer"></canvas>
    </div>
@endcan

<!-- Scatter Chart -->
<div class="chart-container">
    <h2>Project Distribution Over Time (Scatter Chart)</h2>
    <canvas id="myScatterChart"></canvas>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Pie Chart for User
        @can('isUser')
            var ctxPieUser = document.getElementById('myPieChartUser').getContext('2d');
            new Chart(ctxPieUser, {
                type: 'pie',
                data: {
                    labels: ['Completed', 'Pending', 'Rejected'],
                    datasets: [{
                        data: [
                                                    {{ $usercompletedProjects }},
                                                    {{ $userpendingProjects }},
                            {{ $userrejectedProjects }}
                        ],
                        backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 159, 64, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                        borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 159, 64, 1)', 'rgba(255, 99, 132, 1)'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        @endcan

        // Pie Chart for Freelancer
        @can('isFreelancer')
            var ctxPieFreelancer = document.getElementById('myPieChartFreelancer').getContext('2d');
            new Chart(ctxPieFreelancer, {
                type: 'pie',
                data: {
                    labels: ['Completed', 'Pending', 'Rejected'],
                    datasets: [{
                        data: [
                                                    {{ $freelancercompletedProjects }},
                                                    {{ $freelancerpendingProjects }},
                            {{ $freelancerrejectedProjects }}
                        ],
                        backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 159, 64, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                        borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 159, 64, 1)', 'rgba(255, 99, 132, 1)'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        @endcan

        // Scatter Chart
        var ctxScatter = document.getElementById('myScatterChart').getContext('2d');
        new Chart(ctxScatter, {
            type: 'scatter',
            data: {
                datasets: [
                    {
                        label: 'User Projects',
                        data: [
                            { x: 1, y: {{ $usercompletedProjects }} },
                            { x: 2, y: {{ $userpendingProjects }} },
                            { x: 3, y: {{ $userrejectedProjects }} }
                        ],
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Freelancer Projects',
                        data: [
                            { x: 1, y: {{ $freelancercompletedProjects }} },
                            { x: 2, y: {{ $freelancerpendingProjects }} },
                            { x: 3, y: {{ $freelancerrejectedProjects }} }
                        ],
                        backgroundColor: 'rgba(255, 159, 64, 0.5)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        type: 'linear',
                        position: 'bottom'
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection