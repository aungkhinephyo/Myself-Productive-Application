<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\LibraryType;
use App\Models\TodolistType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminPageController extends Controller
{
    public function adminPanel()
    {
        $id = auth()->id();

        $userCount = User::role('user')->count();
        $todolistTypeCount = TodolistType::count();
        $libraryTypeCount = LibraryType::count();

        #For line chart
        $lineChartData = User::role('user')
            ->orderBy('created_at', 'asc')
            ->select('id', 'created_at')
            ->get()
            ->groupBy(function ($lineChartData) {
                return $lineChartData->created_at->format('Y-m');
            });
        $months = [];
        $userChartCount = [];
        foreach ($lineChartData as $month => $values) {
            $months[] = Carbon::parse($month)->format('M');
            $userChartCount[] = count($values);
        }

        $pieChartData = User::role('user')
            ->select('id', 'job')
            ->get()
            ->groupBy(function ($pieChartData) {
                return $pieChartData->job;
            });
        $jobs = [];
        $jobChartCount = [];
        foreach ($pieChartData as $job => $values) {
            $jobs[] = $job ? $job : 'Unknown';
            $jobChartCount[] = count($values);
        }

        return view('admin.admin_panel', compact(
            'userCount',
            'todolistTypeCount',
            'libraryTypeCount',
            'months',
            'userChartCount',
            'pieChartData',
            'jobs',
            'jobChartCount'
        ));
    }
}
