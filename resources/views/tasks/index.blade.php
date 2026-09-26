<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskBoard</title>
    <style>
        body { font-family: system-ui, sans-serif; background: #f3f4f6; color: #1f2937; margin: 0; display: flex; min-height: 100vh; }
        aside { width: 240px; background: #0b46be; color: white; padding: 24px 20px; display: flex; flex-direction: column; flex-shrink: 0; }
        .logo { font-size: 1.25rem; font-weight: 800; margin-bottom: 30px; display: flex; align-items: center; gap: 8px; }
        .logo span { background: white; color: #0b46be; padding: 2px 6px; border-radius: 4px; }
        .nav-l { display: block; padding: 10px; color: #dbeafe; text-decoration: none; border-radius: 6px; font-weight: 500; margin-bottom: 4px; }
        .nav-l.active { background: rgba(255,255,255,0.15); color: white; }
        .foot { margin-top: auto; text-align: center; font-size: 0.8rem; background: rgba(255,255,255,0.1); padding: 10px; border-radius: 6px; }
        main { flex: 1; padding: 40px; overflow-y: auto; }
        .title { font-size: 2.25rem; font-weight: 800; margin: 0 0 8px 0; line-height: 1.2; }
        .grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
        .stat { background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb; }
        .stat-n { font-size: 1.75rem; font-weight: 800; display: block; }
        .stat-l { font-size: 0.7rem; color: #9ca3af; text-transform: uppercase; font-weight: 700; }
        .card { background: white; border-radius: 12px; border: 1px solid #e5e7eb; padding: 24px; margin-bottom: 24px; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { padding: 12px; font-size: 0.75rem; color: #9ca3af; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; }
        td { padding: 14px 12px; border-bottom: 1px solid #f3f4f6; font-size: 0.9rem; }
        .btn-b { font-size: 0.7rem; font-weight: 700; padding: 4px 8px; border-radius: 4px; border: none; cursor: pointer; text-transform: uppercase; }
        .b-p { background: #fef9c3; color: #854d0e; }
        .b-c { background: #dcfce7; color: #166534; }
        .act-e { font-size: 0.85rem; font-weight: 600; color: #0b46be; text-decoration: none; margin-right: 12px; }
        .act-e:hover { text-decoration: underline; }
        .act-d { font-size: 0.85rem; font-weight: 600; color: #dc2626; background: none; border: none; cursor: pointer; padding: 0; }
        .act-d:hover { text-decoration: underline; }
        .line-through { text-decoration: line-through; color: #9ca3af !important; }
    </style>
</head>
<body>

    <!-- Left Navbar Sidebar Panel Layout -->
    <aside>
        <div class="logo"><span>✓</span> TaskBoard</div>
        <p style="font-size:0.7rem; font-weight:700; color:#93c5fd; text-transform:uppercase; margin:0 0 8px 4px;">Workspace</p>
        <nav>
            <a href="/?workspace=all" class="nav-l active">📋 All tasks</a>
            <a href="/tasks/create" class="nav-l">➕ Add new task</a>
        </nav>
        <div class="foot">
            <div style="font-weight:700;">Kyle Andrei Narvasa</div>
            <div style="font-size:0.7rem; opacity:0.8; margin-top:2px;">WST21-PM-2026-SF</div>
        </div>
    </aside>

    <!-- Main Workspace Dashboard Content Panel Area -->
    <main>
        <p style="font-size:0.75rem; font-weight:700; color:#9ca3af; text-transform:uppercase; margin:0 0 4px 0;">Personal task manager / Dashboard</p>
        <p style="font-size:0.75rem; font-weight:700; color:#0b46be; text-transform:uppercase; margin:0 0 8px 0;">YOUR WEEK IN VIEW</p>
        <h2 class="title">Small steps.<br>Real progress.</h2>
        <p style="color:#6b7280; font-size:0.95rem; margin:0 0 30px 0;">Keep the important things moving. Add a task, give it a deadline, and make space for what comes next.</p>

        <!-- Summary Statistics Row Grid Layout -->
        <section class="grid">
            <div class="stat"><span class="stat-n">{{ $tasks->count() }}</span><span class="stat-l">Total Tasks</span></div>
            <div class="stat"><span class="stat-n" style="color:#1f2937;">{{ $tasks->where('status', 'Pending')->count() }}</span><span class="stat-l">Still to Do</span></div>
            <div class="stat"><span class="stat-n" style="color:#16a34a;">{{ $tasks->where('status', 'Completed')->count() }}</span><span class="stat-l">Completed</span></div>
        </section>

        @if(session('success'))
            <p style="color:#166534; font-weight:600; margin-bottom:15px; background:#f0fdf4; padding:10px; border-radius:6px; border:1px solid #bbf7d0;">✨ {{ session('success') }}</p>
        @endif

        <!-- Recent Tasks Dynamic Layout Grid Matrix -->
        <div class="card">
            <h3 style="margin-top:0; color:#374151; font-size:1rem; text-transform:uppercase; border-bottom:1px solid #f3f4f6; padding-bottom:10px;">Recent Tasks</h3>
            @if($tasks->isEmpty())
                <p style="text-align:center; color:#9ca3af; padding:10px 0;">No tasks found on your board.</p>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Task Name</th>
                            <th>Description</th>
                            <th style="text-align:center;">Status</th>
                            <th>Due Date</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                            <tr>
                                <td style="font-weight:600;" class="{{ $task->status === 'Completed' ? 'line-through' : '' }}">{{ $task->task_name }}</td>
                                <td style="color:#6b7280;">{{ $task->description ?? 'No description.' }}</td>
                                <td style="text-align:center;">
                                    <!-- FIXED RELATIVE PATH FOR STATUS ACTION FORM -->
                                    <form action="/tasks/{{ $task->id }}/status" method="POST" style="margin:0;">
                                        @csrf 
                                        @method('PATCH')
                                        <button type="submit" class="btn-b {{ $task->status === 'Completed' ? 'b-c' : 'b-p' }}">{{ $task->status }}</button>
                                    </form>
                                </td>
                                <td style="color:#6b7280; font-weight:500;">{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : 'No deadline' }}</td>
                                <td style="text-align:right; white-space:nowrap;">
                                    <!-- FIXED RELATIVE PATH FOR EDIT LINK -->
                                    <a href="/tasks/{{ $task->id }}/edit" class="act-e">Edit</a>
                                    
                                    <!-- CRITICAL FIXED RELATIVE PATH FOR CHRONOLOGICAL RESOURCE REMOVAL FORM -->
                                    <form action="/tasks/{{ $task->id }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?');" style="display:inline; margin:0;">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="act-d">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </main>

</body>
</html>
