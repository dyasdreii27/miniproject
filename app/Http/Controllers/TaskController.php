<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // View Tasks (Dashboard Homepage)
    public function index()
    {
        $tasks = Task::latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    // Open Add Task Page
    public function create()
    {
        return view('tasks.create');
    }

    // Add Task Handler
    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_name' => 'required|max:255',
            'description' => 'nullable',
            'due_date' => 'nullable|date',
        ]);

        Task::create([
            'task_name' => $validated['task_name'],
            'description' => $validated['description'],
            'due_date' => $validated['due_date'],
            'status' => 'Pending',
        ]);

        // Fail-safe browser redirect bypasses cloud proxy host bugs
        return response("<script>alert('Task created successfully!'); window.location.href='/';</script>");
    }

    // Open Edit Page
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.edit', compact('task'));
    }

    // Save Edit Changes Handler
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'task_name' => 'required|max:255',
            'description' => 'nullable',
            'due_date' => 'nullable|date',
        ]);

        $task = Task::findOrFail($id);
        $task->update($validated);

        return response("<script>alert('Task updated successfully!'); window.location.href='/';</script>");
    }

    // Toggle Task Status (Pending / Completed)
    public function updateStatus($id)
    {
        $task = Task::findOrFail($id);
        $task->status = $task->status === 'Pending' ? 'Completed' : 'Pending';
        $task->save();

        return response("<script>window.location.href='/';</script>");
    }

    // Secure Delete Action Handler
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response("<script>alert('Task deleted successfully!'); window.location.href='/';</script>");
    }
}
