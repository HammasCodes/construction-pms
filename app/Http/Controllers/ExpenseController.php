<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Project;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Project $project)
    {
        $expenses = $project->expenses()->latest('date')->get();

        return view('expenses.index', compact('project', 'expenses'));
    }

    public function create(Project $project)
    {
        return view('expenses.create', compact('project'));
    }

    public function store(Request $request, Project $project)
    {
        $data = $this->validateData($request);

        $project->expenses()->create($data);

        return redirect()
            ->route('projects.show', ['project' => $project, 'tab' => 'expenses'])
            ->with('success', 'Expense recorded successfully.');
    }

    public function show(Project $project, Expense $expense)
    {
        return view('expenses.show', compact('project', 'expense'));
    }

    public function edit(Project $project, Expense $expense)
    {
        return view('expenses.edit', compact('project', 'expense'));
    }

    public function update(Request $request, Project $project, Expense $expense)
    {
        $data = $this->validateData($request);

        $expense->update($data);

        return redirect()
            ->route('projects.show', ['project' => $project, 'tab' => 'expenses'])
            ->with('success', 'Expense updated successfully.');
    }

    public function destroy(Project $project, Expense $expense)
    {
        $expense->delete();

        return redirect()
            ->route('projects.show', ['project' => $project, 'tab' => 'expenses'])
            ->with('success', 'Expense deleted successfully.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'type' => ['required', 'in:material,labour,equipment,other'],
            'description' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'numeric', 'min:0'],
            'unit' => ['nullable', 'string', 'max:50'],
            'rate' => ['required', 'numeric', 'min:0'],
            'date' => ['required', 'date'],
            'vendor' => ['nullable', 'string', 'max:255'],
            'remarks' => ['nullable', 'string'],
        ]);
    }
}
