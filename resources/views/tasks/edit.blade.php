<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <style>
        body { font-family: system-ui, sans-serif; background: #f3f4f6; color: #1f2937; margin: 0; display: flex; min-height: 100vh; }
        aside { width: 240px; background: #0b46be; color: white; padding: 24px 20px; display: flex; flex-direction: column; flex-shrink: 0; }
        .logo { font-size: 1.25rem; font-weight: 800; margin-bottom: 30px; display: flex; align-items: center; gap: 8px; }
        .logo span { background: white; color: #0b46be; padding: 2px 6px; border-radius: 4px; }
        .nav-l { display: block; padding: 10px; color: #dbeafe; text-decoration: none; border-radius: 6px; font-weight: 500; margin-bottom: 4px; }
        .nav-l.active { background: rgba(255,255,255,0.15); color: white; }
        .foot { margin-top: auto; text-align: center; font-size: 0.8rem; background: rgba(255,255,255,0.1); padding: 10px; border-radius: 6px; }
        main { flex: 1; padding: 40px; overflow-y: auto; }
        .card { background: white; border-radius: 12px; border: 1px solid #e5e7eb; padding: 24px; max-width: 500px; }
        .grp { margin-bottom: 14px; }
        .grp label { display: block; font-size: 0.75rem; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; }
        .grp input, .grp textarea { width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box; }
        .btn-s { background: #0b46be; color: white; border: none; padding: 12px 24px; border-radius: 6px; font-weight: 600; cursor: pointer; }
        .cancel-l { text-decoration: none; color: #6b7280; font-size: 0.9rem; font-weight: 600; }
    </style>
</head>
<body>

    <aside>
        <div class="logo"><span>✓</span> TaskBoard</div>
        <p style="font-size:0.7rem; font-weight:700; color:#93c5fd; text-transform:uppercase; margin:0 0 8px 4px;">Workspace</p>
        <nav>
            <a href="{{ route('tasks.index') }}" class="nav-l active">📋 All tasks</a>
            <a href="{{ route('tasks.create') }}" class="nav-l">➕ Add new task</a>
        </nav>
        <div class="foot">
            <div style="font-weight:700;">Kyle Andrei Narvasa</div>
            <div style="font-size:0.7rem; opacity:0.8; margin-top:2px;">WST21-PM-2026-SF</div>
        </div>
    </aside>

    <main>
        <div style="display:flex; justify-content:space-between; align-items:center; max-width:500px; margin-bottom:20px;">
            <h2 style="margin:0;">📝 Edit Task</h2>
            <a href="{{ route('tasks.index') }}" class="cancel-l">← Back</a>
        </div>

        <div class="card">
            <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grp"><label>Task Name</label><input type="text" name="task_name" value="{{ $task->task_name }}" required></div>
                <div class="grp"><label>Description</label><textarea name="description" rows="3">{{ $task->description }}</textarea></div>
                <div class="grp"><label>Due Date</label><input type="date" name="due_date" value="{{ $task->due_date }}"></div>
                <button type="submit" class="btn-s">Save Changes</button>
            </form>
        </div>
    </main>

</body>
</html>
