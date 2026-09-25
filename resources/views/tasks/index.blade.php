@extends('layouts.app')

@section('content')
<div class="page-head">
    <div>
        <div class="eyebrow">Your week, in view</div>
        <h1>Small steps.<br>Real progress.</h1>
        <p class="intro">Keep the important things moving. Add a task, give it a deadline, and make space for what comes next.</p>
    </div>
    <a class="button" href="#add-task">+ Add task</a>
</div>

@if (session('success'))
    <div class="flash">{{ session('success') }}</div>
@endif

<div class="stats">
    <div class="stat"><strong>{{ $totalTasks }}</strong><span>Total tasks</span></div>
    <div class="stat"><strong>{{ $pendingTasks }}</strong><span>Still to do</span></div>
    <div class="stat"><strong>{{ $completedTasks }}</strong><span>Completed</span></div>
</div>

<form id="add-task" class="add-panel" method="POST" action="{{ route('tasks.store') }}">
    @csrf
    <div class="field">
        <label for="task_name">Task name</label>
        <input id="task_name" name="task_name" type="text" placeholder="e.g. Finish project brief" value="{{ old('task_name') }}" required>
    </div>
    <div class="field">
        <label for="description">Description</label>
        <textarea id="description" name="description" placeholder="Add notes or details...">{{ old('description') }}</textarea>
    </div>
    <div class="field">
        <label for="status">Status</label>
        <select id="status" name="status" required>
            <option value="Pending" @selected(old('status', 'Pending') === 'Pending')>Pending</option>
            <option value="Completed" @selected(old('status') === 'Completed')>Completed</option>
        </select>
    </div>
    <div class="field">
        <label for="due_date">Due date</label>
        <input id="due_date" name="due_date" type="date" value="{{ old('due_date') }}">
    </div>
    <button class="button" type="submit">Add task</button>
</form>

@if ($errors->any())
    <div class="errors"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

<div class="task-heading">
    <h2>Recent tasks</h2>
    <span>{{ $totalTasks }} {{ $totalTasks === 1 ? 'task' : 'tasks' }} tracked</span>
</div>

<section class="task-table" aria-label="Task list">
    <div class="task-table-head"><span>Task</span><span>Description</span><span>Status</span><span>Due date</span><span>Actions</span></div>
    @if ($tasks->isEmpty())
        <div class="empty"><h2>Your list is waiting.</h2><p>Start with one thing you would like to get done above.</p></div>
    @else
        <div class="task-list">
            @foreach ($tasks as $task)
                <article class="task">
                    <h2>{{ $task->task_name }}</h2>
                    <p>{{ $task->description ?: 'No description added.' }}</p>
                    <div class="meta"><span class="pill {{ $task->status === 'Completed' ? 'completed' : '' }}">{{ $task->status }}</span></div>
                    <span class="due-date">{{ $task->due_date ? $task->due_date->format('M j, Y') : 'No deadline' }}</span>
                    <div class="actions">
                        <form method="POST" action="{{ route('tasks.status', $task) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="{{ $task->status === 'Pending' ? 'Completed' : 'Pending' }}"><button class="button secondary" type="submit">{{ $task->status === 'Pending' ? 'Complete' : 'Reopen' }}</button></form>
                        <a class="icon-link" href="{{ route('tasks.edit', $task) }}">Edit</a>
                        <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Delete this task?')">@csrf @method('DELETE')<button class="icon-link" type="submit">Delete</button></form>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</section>
@endsection
