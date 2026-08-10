<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Reports hub — list every project with its report actions.
     */
    public function index()
    {
        $projects = Project::with(['boqItems', 'expenses', 'progressTasks'])
            ->latest()
            ->get();

        return view('reports.index', compact('projects'));
    }

    /**
     * Download the project report as a PDF.
     */
    public function pdf(Project $project)
    {
        return $this->build($project)->download($this->filename($project));
    }

    /**
     * Open the project report inline (in the browser tab).
     */
    public function view(Project $project)
    {
        return $this->build($project)->stream($this->filename($project));
    }

    private function build(Project $project)
    {
        $project->load(['boqItems', 'expenses' => fn ($q) => $q->orderBy('date'), 'progressTasks']);

        return Pdf::loadView('reports.pdf', compact('project'))
            ->setPaper('a4', 'portrait');
    }

    private function filename(Project $project): string
    {
        return 'project-report-'.str($project->name)->slug().'.pdf';
    }
}
