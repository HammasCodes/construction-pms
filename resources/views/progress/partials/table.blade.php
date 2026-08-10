<div class="card overflow-hidden">
    <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
        <div class="flex items-center gap-3">
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-black text-brand-500 shadow-md">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-gray-900">Progress &amp; Milestones</h3>
                <p class="text-xs text-gray-400">{{ $tasks->count() }} task(s)</p>
            </div>
        </div>
        <a href="{{ route('projects.progress.create', $project) }}" class="btn-primary">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Task
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100 text-sm">
            <thead class="bg-gray-50/80 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-4 py-3">Milestone</th>
                    <th class="px-4 py-3">Planned / Completed</th>
                    <th class="px-4 py-3 w-48">Completion</th>
                    <th class="px-4 py-3">Start</th>
                    <th class="px-4 py-3">Due</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($tasks as $task)
                    <tr class="transition hover:bg-brand-50/40">
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $task->milestone }}</td>
                        <td class="px-4 py-3 text-gray-600">
                            <p class="text-xs"><span class="text-gray-400">Planned:</span> {{ $task->planned_work ?: '—' }}</p>
                            <p class="text-xs"><span class="text-gray-400">Done:</span> {{ $task->completed_work ?: '—' }}</p>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <div class="h-2 w-full overflow-hidden rounded-full bg-gray-100">
                                    <div class="h-full rounded-full bg-brand-500" style="width: {{ $task->completion_percentage }}%"></div>
                                </div>
                                <span class="w-9 text-right text-xs font-medium text-gray-600">{{ $task->completion_percentage }}%</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ optional($task->start_date)->format('d M Y') ?: '—' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ optional($task->due_date)->format('d M Y') ?: '—' }}</td>
                        <td class="px-4 py-3"><span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $task->statusColor() }}">{{ $task->statusLabel() }}</span></td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('projects.progress.edit', [$project, $task]) }}" class="rounded-md px-2 py-1 text-xs font-bold text-black transition hover:bg-brand-500">Edit</a>
                                <form method="POST" action="{{ route('projects.progress.destroy', [$project, $task]) }}" onsubmit="return confirm('Delete this task?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="rounded-md px-2 py-1 text-xs font-bold text-black transition hover:bg-black hover:text-white">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-10 text-center text-gray-400">No progress tasks yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
