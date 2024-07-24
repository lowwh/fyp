<!-- resources/views/operations/graph.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ratings Graph</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div style="width: 80%; margin: auto;">
        <canvas id="ratingsChart"></canvas>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('ratingsChart').getContext('2d');
            const chartData = @json($chartData);

            new Chart(ctx, {
                type: 'bar', // or 'line', 'pie', 'doughnut', etc.
                data: chartData,
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Rating Value'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Count'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                color: 'rgb(75, 192, 192)'
                            }
                        },
                        title: {
                            display: true,
                            text: 'Ratings Distribution'
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>