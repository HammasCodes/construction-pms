<?php

namespace App\Http\Controllers;

use App\Models\BoqItem;
use App\Models\Project;
use Illuminate\Http\Request;

class BoqItemController extends Controller
{
    public function index(Project $project)
    {
        $boqItems = $project->boqItems()->latest()->get();

        return view('boq.index', compact('project', 'boqItems'));
    }

    public function create(Project $project)
    {
        return view('boq.create', compact('project'));
    }

    public function store(Request $request, Project $project)
    {
        $data = $this->validateData($request);

        $project->boqItems()->create($data);

        return redirect()
            ->route('projects.show', ['project' => $project, 'tab' => 'boq'])
            ->with('success', 'BOQ item added successfully.');
    }

    public function show(Project $project, BoqItem $boq)
    {
        return view('boq.show', compact('project', 'boq'));
    }

    public function edit(Project $project, BoqItem $boq)
    {
        return view('boq.edit', compact('project', 'boq'));
    }

    public function update(Request $request, Project $project, BoqItem $boq)
    {
        $data = $this->validateData($request);

        $boq->update($data);

        return redirect()
            ->route('projects.show', ['project' => $project, 'tab' => 'boq'])
            ->with('success', 'BOQ item updated successfully.');
    }

    public function destroy(Project $project, BoqItem $boq)
    {
        $boq->delete();

        return redirect()
            ->route('projects.show', ['project' => $project, 'tab' => 'boq'])
            ->with('success', 'BOQ item deleted successfully.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'category' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'unit' => ['nullable', 'string', 'max:50'],
            'quantity' => ['required', 'numeric', 'min:0'],
            'rate' => ['required', 'numeric', 'min:0'],
            'tax_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'remarks' => ['nullable', 'string'],
        ]);
    }
}
