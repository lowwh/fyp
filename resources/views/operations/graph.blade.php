@extends('layouts.app')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: center; align-items: center; height: 400px;">
        <canvas id="ratingsChart" style="width: 90%; height: 80%;"></canvas>
    </div>
    <div style="display: flex; justify-content: center; align-items: center; height: 400px; margin-top:100px">
        <canvas id="pieChart" style="width: 90%; height: 80%;"></canvas>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx1 = document.getElementById('ratingsChart').getContext('2d');
        const ctx2 = document.getElementById('pieChart').getContext('2d');

        // Data for the bar chart
        const chartData = @json($chartData);

        new Chart(ctx1, {
            type: 'bar',
            data: chartData,
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Status (Pending, Completed, Rejected)'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Status Count'
                        },
                        grid: {
                            display: false
                        },
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'rectRot',
                            boxWidth: 0
                        }
                    },
                    title: {
                        display: true,
                        text: 'Project Status Distribution'
                    }
                }
            }
        });

        // Data for the pie chart
        const pieChartData = @json($pieChartData);

        new Chart(ctx2, {
            type: 'pie',
            data: pieChartData,
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: 'Project Status Distribution (Pie Chart)'
                    }
                }
            }
        });



    });
</script>
@endsection