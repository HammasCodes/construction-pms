<?php

namespace App\Http\Controllers;

use App\Models\Project;

class DashboardController extends Controller
{
    public function index()
    {
        $projects = Project::with(['boqItems', 'expenses', 'progressTasks'])
            ->latest()
            ->get();

        $totals = [
            'projects' => $projects->count(),
            'in_progress' => $projects->where('status', 'in_progress')->count(),
            'completed' => $projects->where('status', 'completed')->count(),
            'estimated_budget' => $projects->sum('estimated_budget'),
            'total_expenses' => $projects->sum(fn (Project $project) => $project->totalExpenses()),
        ];

        return view('dashboard', compact('projects', 'totals'));
    }
}
