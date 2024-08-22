@extends('layouts.app')

@section('content')
<style>
    .flex-container {
        display: flex;
        justify-content: center;



    }

    ;
</style>
<div class="flex-container">
    <div class="chart-container1"
        style="position: relative; height: 400px; width:600px; margin-right: 100px; margin-top:100px">
        <canvas id="ratingsChart"></canvas>
    </div>
    <div class="chart-container2"
        style="position: relative; height: 400px;width:400px; margin-top: 100px; margin-left:200px">
        <canvas id="pieChart"></canvas>
    </div>

    <div class="chart-container" style="position: relative; height:400px; margin-top:100px">
        <canvas id="barChartData"></canvas>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx1 = document.getElementById('ratingsChart').getContext('2d');
        const ctx2 = document.getElementById('pieChart').getContext('2d');



        const ctx3 = document.getElementById('barChartData').getContext('2d');

        // Data for the bar chart
        const chartData = @json($chartData);

        new Chart(ctx1, {
            type: 'bar',
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Status (Pending, Completed, Rejected)',
                            font: {
                                size: 16
                            }
                        },
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Status Count',
                            font: {
                                size: 16
                            }
                        },
                        ticks: {
                            stepSize: 1,
                            color: '#333'
                        },
                        grid: {
                            color: '#e3e3e3',
                            display: true
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
                            boxWidth: 10,
                            padding: 15,
                            font: {
                                size: 14
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Project Status Distribution',
                        font: {
                            size: 18
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.raw || 0;
                                return label;
                            }
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeOutBounce'
                }
            }
        });

        // Data for the pie chart
        const pieChartData = @json($pieChartData);

        new Chart(ctx2, {
            type: 'pie',
            data: pieChartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: 14
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Project Status Distribution (Pie Chart)',
                        font: {
                            size: 18
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let label = context.label || '';
                                let value = context.raw || 0;
                                return `${label}: ${value}`;
                            }
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeInOutQuad'
                }
            }
        });


    });
</script>
@endsection