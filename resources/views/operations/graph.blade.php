@extends('layouts.app')

@section('content')
<style>
    .flex-container {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 30px;
        margin-top: 10px;
        /* Reduced top margin */
        margin-bottom: 0px;
        /* Reduced bottom margin */
    }

    .flex-container2 {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 10px;
        /* Reduced top margin */
        margin-bottom: 0px;
        /* Ensure no extra margin at the bottom */
    }

    /* General styling for stat cards */
    .stat-card {
        background: linear-gradient(145deg, #e6e6e6, #ffffff);
        border-radius: 12px;
        padding: 20px;
        box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.1);
        text-align: center;
        width: 200px;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    /* Hover effect for stat cards */
    .stat-card:hover {
        transform: scale(1.05);
        box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.15);
    }

    /* Stat card heading styling */
    .stat-card h3 {
        margin: 0;
        font-size: 18px;
        color: #333;
    }

    /* Stat card paragraph styling */
    .stat-card p {
        margin: 10px 0 0;
        font-size: 24px;
        font-weight: bold;
        color: #007bff;
    }

    /* Styling for tables */
    table {
        width: 80%;
        border-collapse: collapse;
        margin: 20px auto 5px auto;
        /* Set bottom margin to 5px */
        background-color: #ffffff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s;
    }

    /* Table header styling */
    th {
        background-color: #f4f4f4;
        font-weight: bold;
        color: #333;
        padding: 12px 15px;
        border: 1px solid #ddd;
    }

    /* Table row styling */
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    /* Table row hover effect */
    tr:hover {
        background-color: #e9f5ff;
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.2);
    }

    /* Table cell styling */
    td {
        padding: 12px 15px;
        border: 1px solid #ddd;
        font-size: 20px;
        color: #555;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .flex-container {
            flex-direction: column;
            align-items: center;
        }

        table {
            width: 100%;
        }
    }

    .text-success {
        color: green
    }

    .text-pending {
        color: orange
    }

    .text-rejected {
        color: red
    }

    .highlight-due-date {
        background-color: #ffffcc;
        /* Light yellow background */
        border: 2px solid #ffcc00;
        /* Yellow border */
        font-weight: bold;
    }
</style>



<!-- <div class="announcement-bar">
    <p>New feature release: Real-time data filtering now available!</p>
</div> -->
<div class="summary-container">
    @can('isUser')
        <div class="flex-container">
            <div class="stat-card">
                <h3>Total Service</h3>
                <p>{{ $totalUsers }}</p>
            </div>
            <div class="stat-card">
                <h3>Completed Service</h3>
                <p>{{ $usercompletedProjects }}</p>
            </div>
            <div class="stat-card">
                <h3>Pending Service</h3>
                <p>{{ $userpendingProjects }}</p>
            </div>
            <div class="stat-card">
                <h3>Rejected Service</h3>
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
<div class="flex-container">
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Gig ID</th>
                <th>Date</th>
                <th>Estimate Delivery Date</th>
                <th>Status</th>
                <th>Progress</th>
            </tr>
        </thead>
        <tbody>
            @php
                // Find the closest due date
                $closestDueDate = $tabledata
                    ->whereNotNull('estimate_delivery_date') // Exclude null estimate_delivery_date
                    ->sortBy('estimate_delivery_date') // Sort by estimate_delivery_date
                    ->first() // Get the first (closest) due date
                    ->estimate_delivery_date ?? null;
            @endphp
            @foreach($tabledata as $data)
                        @php
                            // Check if the current row's due date is the closest one
                            $isClosest = $data->estimate_delivery_date == $closestDueDate;

                            //Get the current date 
                            $currentdate = date('Y-m-d');
                        @endphp
                        <!-- highlight the closest date -->
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->gig_id }}</td>
                            <td>{{ $currentdate }}</td>
                            <td>{{ $data->estimate_delivery_date }}</td>
                            @if($data->status === 'Completed')
                                <td class="text-success">{{ $data->status }}</td>
                            @elseif($data->status === 'Pending')
                                <td class="text-pending">{{ $data->status }}</td>
                            @elseif($data->status === 'Rejected')
                                <td class="text-rejected">{{ $data->status }}</td>
                            @endif
                            <td>{{ $data->progress }} %</td>
                        </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="flex-container">
    <div class="chart-container1" style="position: relative; height: 400px; width:600px; margin-top:80px">
        <canvas id="ratingsChart"></canvas>
    </div>

</div>

</div>


<div class="flex-container2">
    <div class="chart-container" style="position: relative; height:400px; width:1000px;">
        <canvas id="barChartData"></canvas>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@latest"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx1 = document.getElementById('ratingsChart').getContext('2d');
        // const ctx2 = document.getElementById('pieChart').getContext('2d');
        const ctx3 = document.getElementById('barChartData').getContext('2d');

        // Data for the charts
        const chartData = @json($chartData);

        const barChartData = @json($barChartData);

        new Chart(ctx1, {
            type: 'bar',
            data: chartData, // Use the chartData prepared in your PHP code
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: { display: true, text: 'Date', font: { size: 20 } },
                        grid: { display: false }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Progress (%)',
                            color: '#333',
                            font: { size: 20 }
                        },
                        beginAtZero: true,
                        max: 100,  // Set the maximum value of the y-axis to 100
                        ticks: {
                            stepSize: 10, // Set step size to 10 for better readability
                            callback: function (value, index, values) {
                                return value.toFixed(2) + '%'; // Format values with 2 decimal places and add a percentage sign
                            }
                        },
                        grid: {
                            display: true,
                            color: '#e3e3e3',
                            lineWidth: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            font: { size: 20 }
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeOutBounce'
                }
            }
        });








        // Bar chart
        // new Chart(ctx3, {
        //     type: 'bar',
        //     data: barChartData,
        //     options: {
        //         responsive: true,
        //         maintainAspectRatio: false,
        //         scales: {
        //             x: {
        //                 title: { display: true, text: 'Date', font: { size: 16 } },
        //                 grid: { display: false }
        //             },
        //             y: {
        //                 beginAtZero: true,
        //                 title: { display: true, text: 'Count', font: { size: 16 } },
        //                 ticks: { stepSize: 1, color: '#333' },
        //                 grid: { color: '#e3e3e3' }
        //             }
        //         },
        //         plugins: {
        //             legend: { display: true, position: 'top', labels: { usePointStyle: true, font: { size: 14 } } },
        //             tooltip: {
        //                 callbacks: {
        //                     label: function (context) {
        //                         return `${context.dataset.label}: ${context.raw}`;
        //                     }
        //                 }
        //             }
        //         },
        //         animation: { duration: 1000, easing: 'easeOutBounce' }
        //     }
        // });
    });

</script>
@endsection