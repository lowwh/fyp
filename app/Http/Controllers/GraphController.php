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
        $totalUsers = Result::where('bidder_id', $userId)
            ->orWhere('user_id', $userId)
            ->count();
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

        $statuses = Result::select(
            'id',
            'status',
            'progress',
            'gig_id',
            'created_at',
            'estimate_delivery_date',
            DB::raw('DATEDIFF(estimate_delivery_date, NOW()) as days_left')
        )
            ->where(function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->orWhere('bidder_id', $userId);
            })
            ->whereNotNull('estimate_delivery_date') // Exclude entries where estimate_delivery_date is null
            ->where('status', '!=', 'Completed')
            ->orderByRaw('days_left ASC') // Order by delivery date, then by creation date
            ->take(3) // Limit to the latest 3 entries
            ->get();



        // Define default colors
        $defaultColor = 'rgba(200, 200, 200, 0.2)'; // Grey (default background color)
        $defaultBorderColor = 'rgba(200, 200, 200, 1)'; // Grey (default border color)

        // Prepare labels (dates) and data (progress) for Chart.js
        $labels = $statuses->pluck('created_at')->map(function ($date) {
            return $date->format('Y-m-d'); // Format the date as 'YYYY-MM-DD'
        })->toArray();

        $progressData = $statuses->pluck('progress')->map(function ($progress) {
            return number_format($progress, 2); // Format progress as 2 decimal places
        })->toArray();

        // Determine colors based on status
        $backgroundColors = [];
        $borderColors = [];

        foreach ($statuses as $status) {
            switch ($status->status) {
                case 'Pending':
                    $backgroundColors[] = 'rgba(255, 255, 0, 0.2)'; // Yellow for Pending
                    $borderColors[] = 'rgba(255, 204, 0, 1)';        // Yellow border
                    break;
                case 'Rejected':
                    $backgroundColors[] = 'rgba(255, 0, 0, 0.2)';   // Red for Rejected
                    $borderColors[] = 'rgba(255, 0, 0, 1)';          // Red border
                    break;
                case 'Completed':
                    if ($status->progress == 100 && $status->status === 'Completed') {
                        $backgroundColors[] = 'rgba(0, 255, 0, 0.2)'; // Green for Completed with 100% progress
                        $borderColors[] = 'rgba(0, 255, 0, 1)';       // Green border
                    } else {
                        $backgroundColors[] = $defaultColor;           // Grey for other cases
                        $borderColors[] = $defaultBorderColor;         // Grey border
                    }
                    break;
                default:
                    $backgroundColors[] = $defaultColor;               // Default grey
                    $borderColors[] = $defaultBorderColor;             // Default grey border
                    break;
            }
        }

        // Prepare data for Chart.js
        $chartData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Progress',
                    'data' => $progressData,
                    'backgroundColor' => $backgroundColors, // Use the dynamically set colors
                    'borderColor' => $borderColors,         // Use the dynamically set border colors
                    'borderWidth' => 1,
                ]
            ]
        ];



        // $pieChartData = [
        //     'labels' => $statusesArray,
        //     'datasets' => [
        //         [
        //             'data' => $statuses->pluck('count')->toArray(),
        //             'backgroundColor' => array_slice($colors, 0, $statuses->count()),
        //             'borderColor' => array_slice($borderColors, 0, $statuses->count()),
        //             'borderWidth' => 1,
        //         ]
        //     ]
        // ];

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
        $d = Result::selectRaw("
        date_format(created_at, '%Y-%m-%d') as date,
        status, 
        progress, 
        gig_id, 
        id,
        estimate_delivery_date,
        DATEDIFF(estimate_delivery_date, NOW()) as days_left
    ")
            ->whereDate('created_at', '>=', now()->subDays(30))
            ->where(function ($query) use ($userId) {
                $query->where('bidder_id', $userId)
                    ->orWhere('user_id', $userId);

            })
            ->whereNotNull('estimate_delivery_date') // Exclude entries where estimate_delivery_date is null
            ->where('status', '!=', 'Completed')
            ->orderByRaw('days_left ASC') // Order by closest estimate delivery date to NOW()
            ->take(3) // Limit to the latest 3 entries
            ->get();





        //return $d;




        return view('operations.graph', [
            'chartData' => $chartData,
            // 'pieChartData' => $pieChartData,
            'barChartData' => $barChartData,
            'totalUsers' => $totalUsers,
            'usercompletedProjects' => $usercompletedProjects,
            'userpendingProjects' => $userpendingProjects,
            'userrejectedProjects' => $userrejectedProjects,
            'freelancercompletedProjects' => $freelancercompletedProjects,
            'freelancerpendingProjects' => $freelancerpendingProjects,
            'freelancerrejectedProjects' => $freelancerrejectedProjects,
            'tabledata' => $d
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

    public function showProjectSummary()
    {
        // Replace $userId with the actual user ID you want to use
        $userId = auth()->id();

        $totalUsers = Result::where('bidder_id', $userId)
            ->orWhere('user_id', $userId)
            ->count();
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

        return view('operations.project-summary', compact(
            'totalUsers',
            'usercompletedProjects',
            'userpendingProjects',
            'userrejectedProjects',
            'freelancercompletedProjects',
            'freelancerpendingProjects',
            'freelancerrejectedProjects'
        ));
    }



}
