<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(): View
    {
        $tasks = Task::query()
            ->orderByRaw("CASE WHEN status = 'Pending' THEN 0 ELSE 1 END")
            ->orderBy('due_date')
            ->latest()
            ->get();

        return view('tasks.index', [
            'tasks' => $tasks,
            'totalTasks' => Task::count(),
            'pendingTasks' => Task::where('status', 'Pending')->count(),
            'completedTasks' => Task::where('status', 'Completed')->count(),
        ]);
    }

    public function create(): View
    {
        return view('tasks.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'task_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:Pending,Completed'],
            'due_date' => ['nullable', 'date'],
        ]);

        Task::create($validated);

        return to_route('tasks.index')->with('success', 'Task added successfully.');
    }

    public function edit(Task $task): View
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        $validated = $request->validate([
            'task_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:Pending,Completed'],
            'due_date' => ['nullable', 'date'],
        ]);

        $task->update($validated);

        return to_route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return to_route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function updateStatus(Request $request, Task $task): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:Pending,Completed'],
        ]);

        $task->update($validated);

        return to_route('tasks.index')->with('success', 'Task status updated.');
    }
}
