@extends('layouts.app')

@section('content')
<div class="page-head">
    <div>
        <div class="eyebrow">Your week, in view</div>
        <h1>Small steps.<br>Real progress.</h1>
        <p class="intro">Keep the important things moving. Add a task, give it a deadline, and make space for what comes next.</p>
    </div>
    <a class="button" href="{{ route('tasks.create') }}">+ Add task</a>
</div>

@if (session('success'))
    <div class="flash">{{ session('success') }}</div>
@endif

<div class="stats">
    <div class="stat"><strong>{{ $totalTasks }}</strong><span>Total tasks</span></div>
    <div class="stat"><strong>{{ $pendingTasks }}</strong><span>Still to do</span></div>
    <div class="stat"><strong>{{ $completedTasks }}</strong><span>Completed</span></div>
</div>

@if ($tasks->isEmpty())
    <section class="empty">
        <h2>Your list is waiting.</h2>
        <p>Start with one thing you would like to get done.</p>
        <a class="button" href="{{ route('tasks.create') }}">Create your first task</a>
    </section>
@else
    <section class="task-list" aria-label="Task list">
        @foreach ($tasks as $task)
            <article class="task">
                <div>
                    <h2>{{ $task->task_name }}</h2>
                    @if ($task->description)
                        <p>{{ $task->description }}</p>
                    @endif
                    <div class="meta">
                        <span class="pill {{ $task->status === 'Completed' ? 'completed' : '' }}">{{ $task->status }}</span>
                        @if ($task->due_date)
                            <span>Due {{ $task->due_date->format('M j, Y') }}</span>
                        @else
                            <span>No deadline</span>
                        @endif
                    </div>
                </div>
                <div class="actions">
                    <form method="POST" action="{{ route('tasks.status', $task) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="{{ $task->status === 'Pending' ? 'Completed' : 'Pending' }}">
                        <button class="button secondary" type="submit">{{ $task->status === 'Pending' ? 'Complete' : 'Reopen' }}</button>
                    </form>
                    <a class="icon-link" href="{{ route('tasks.edit', $task) }}">Edit</a>
                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Delete this task?')">
                        @csrf
                        @method('DELETE')
                        <button class="icon-link" type="submit">Delete</button>
                    </form>
                </div>
            </article>
        @endforeach
    </section>
@endif
@endsection
