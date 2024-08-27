<?php

namespace App\Http\Controllers;
use App\Models\Result;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use App\Models\User;


class GraphController extends Controller
{
    public function showRatings()
    {
        $userId = auth()->id();

        // Fetching summary data
        $totalUsers = User::count();
        $usercompletedProjects = Result::where('status', 'Completed')
            ->where('bidder_id', $userId)

            ->count();
        $userpendingProjects = Result::where('status', 'Pending')
            ->where('bidder_id', $userId)

            ->count();
        $userrejectedProjects = Result::where('status', 'Rejected')
            ->where('bidder_id', $userId)
            ->count();

        $freelancercompletedProjects = Result::where('status', 'Completed')
            ->where('user_id', $userId)

            ->count();
        $freelancerpendingProjects = Result::where('status', 'Pending')
            ->where('user_id', $userId)

            ->count();
        $freelancerrejectedProjects = Result::where('status', 'Rejected')
            ->where('user_id', $userId)
            ->count();

        // Fetch project status counts from the database
        $statuses = Result::selectRaw('
        status,
        COUNT(*) as count
    ')
            ->where('user_id', $userId)
            ->orWhere('bidder_id', $userId)
            ->groupBy('status')
            ->orderByRaw("FIELD(status, 'pending', 'completed', 'rejected')") // Ensure order: pending, completed, rejected
            ->get();

        // Define colors for the statuses in the correct order
        $colors = [
            'rgba(255, 159, 64, 0.2)', // Color for Pending
            'rgba(25, 206, 8, 0.2)', // Color for Rejected
            'rgba(255, 99, 132, 0.2)', // Color for Completed
        ];

        // Define an array of border colors for the pie chart segments
        $borderColors = [
            'rgba(255, 159, 64, 1)', // Border color for Pending
            'rgba(25, 206, 8, 1)', // Border color for Rejected
            'rgba(255, 99, 132, 1)', // Border color for Completed
        ];

        // Prepare data for Chart.js
        $statusesArray = $statuses->pluck('status')->toArray();
        $chartData = [
            'labels' => $statusesArray,
            'datasets' => [
                [
                    'label' => 'Project Status Count',
                    'data' => $statuses->pluck('count')->toArray(),
                    'backgroundColor' => array_slice($colors, 0, $statuses->count()),
                    'borderColor' => array_slice($borderColors, 0, $statuses->count()),
                    'borderWidth' => 1,
                ]
            ]
        ];

        $pieChartData = [
            'labels' => $statusesArray,
            'datasets' => [
                [
                    'data' => $statuses->pluck('count')->toArray(),
                    'backgroundColor' => array_slice($colors, 0, $statuses->count()),
                    'borderColor' => array_slice($borderColors, 0, $statuses->count()),
                    'borderWidth' => 1,
                ]
            ]
        ];

        // User bar chart data
        // Define colors for the statuses in the correct order
        $barColors = [
            'rgb(255, 99, 132)',
            'rgb(54, 162, 235)',
            'rgb(255, 205, 86)',
            'rgb(205, 125, 186)',
        ];

        // Define an array of border colors for the pie chart segments
        $barBorderColors = [
            'rgba(255, 159, 64, 1)',
            'rgba(25, 206, 8, 1)',
            'rgba(255, 99, 132, 1)',
        ];

        $data = User::selectRaw("date_format(created_at, '%Y-%m-%d') as date, count(*) as aggregate")
            ->whereDate('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->get();

        $userArray = $data->pluck('date')->toArray();

        $barChartData = [
            'labels' => $userArray,
            'datasets' => [
                [
                    'label' => 'User Registered Count in last 30 days',
                    'data' => $data->pluck('aggregate')->toArray(),
                    'backgroundColor' => array_slice($barColors, 0, $data->count()),
                    'borderColor' => array_slice($barBorderColors, 0, $data->count()),
                    'borderWidth' => 1,
                ]
            ]
        ];



        return view('operations.graph', [
            'chartData' => $chartData,
            'pieChartData' => $pieChartData,
            'barChartData' => $barChartData,
            'totalUsers' => $totalUsers,
            'usercompletedProjects' => $usercompletedProjects,
            'userpendingProjects' => $userpendingProjects,
            'userrejectedProjects' => $userrejectedProjects,
            'freelancercompletedProjects' => $freelancercompletedProjects,
            'freelancerpendingProjects' => $freelancerpendingProjects,
            'freelancerrejectedProjects' => $freelancerrejectedProjects
        ]);
    }



    public function userRegistrationCount()
    {
        $userId = Auth()->id();
        // Define colors for the statuses in the correct order
        $colors = [
            'rgb(255, 99, 132)',
            'rgb(54, 162, 235)',
            'rgb(255, 205, 86)',
            'rgb(205, 125, 186)',
        ];

        // Define an array of border colors for the pie chart segments
        $borderColors = [
            'rgba(255, 159, 64, 1)', // Border color for Pending
            'rgba(25, 206, 8, 1)', // Border color for Rejected
            'rgba(255, 99, 132, 1)', // Border color for Completed
        ];

        $data = User::selectRaw("date_format(created_at, '%Y-%m-%d') as date, count(*) as aggregate")
            ->whereDate('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->get();

        $userArray = $data->pluck('date')->toArray();

        $barChartData = [

            'labels' => $userArray,
            'datasets' => [
                [
                    'label' => 'User Registered Count in last 30 days',
                    'data' => $data->pluck('aggregate')->toArray(),
                    'backgroundColor' => array_slice($colors, 0, $data->count()),
                    'borderColor' => array_slice($borderColors, 0, $data->count()),
                    'borderWidth' => 1,
                ]

            ]

        ];
        return view('graph.userRegistrationCount', ['barChartData' => $barChartData]);
    }
}
