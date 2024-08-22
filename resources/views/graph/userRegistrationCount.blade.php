@extends('layouts.app')

@section('content')
<div class="container">

    <div class="chart-container" style="position: relative; height:400px; margin-top:100px">
        <canvas id="barChartData"></canvas>
    </div>


</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const ctx3 = document.getElementById('barChartData').getContext('2d');

        // Data for the bar chart

        const barChartData = @json($barChartData)

        new Chart(ctx3, {
            type: 'bar',
            data: barChartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date',
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
                            text: 'User Count',
                            font: {
                                size: 16
                            }
                        },
                        ticks: {
                            stepSize: 1,
                            color: '#333'
                        },
                        grid: {
                            color: '#e3e3e3'
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
                        text: 'Registered users in the last 30 days',
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




    });




</script>
@endsection