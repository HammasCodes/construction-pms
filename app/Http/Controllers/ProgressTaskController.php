<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProgressTask;
use Illuminate\Http\Request;

class ProgressTaskController extends Controller
{
    public function index(Project $project)
    {
        $tasks = $project->progressTasks()->latest()->get();

        return view('progress.index', compact('project', 'tasks'));
    }

    public function create(Project $project)
    {
        return view('progress.create', compact('project'));
    }

    public function store(Request $request, Project $project)
    {
        $data = $this->validateData($request);

        $project->progressTasks()->create($data);

        return redirect()
            ->route('projects.show', ['project' => $project, 'tab' => 'progress'])
            ->with('success', 'Progress task added successfully.');
    }

    public function show(Project $project, ProgressTask $progress)
    {
        return view('progress.show', compact('project', 'progress'));
    }

    public function edit(Project $project, ProgressTask $progress)
    {
        return view('progress.edit', compact('project', 'progress'));
    }

    public function update(Request $request, Project $project, ProgressTask $progress)
    {
        $data = $this->validateData($request);

        $progress->update($data);

        return redirect()
            ->route('projects.show', ['project' => $project, 'tab' => 'progress'])
            ->with('success', 'Progress task updated successfully.');
    }

    public function destroy(Project $project, ProgressTask $progress)
    {
        $progress->delete();

        return redirect()
            ->route('projects.show', ['project' => $project, 'tab' => 'progress'])
            ->with('success', 'Progress task deleted successfully.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'milestone' => ['required', 'string', 'max:255'],
            'planned_work' => ['nullable', 'string'],
            'completed_work' => ['nullable', 'string'],
            'completion_percentage' => ['required', 'integer', 'min:0', 'max:100'],
            'start_date' => ['nullable', 'date'],
            'due_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'in:not_started,in_progress,completed'],
            'remarks' => ['nullable', 'string'],
        ]);
    }
}
