<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'TaskBoard' }} · Personal Task Manager</title>
    <style>
        :root { --ink: #17253d; --muted: #718096; --paper: #f4f7fb; --surface: #fff; --line: #e3e9f2; --blue: #2563eb; --blue-dark: #1d4ed8; --navy: #14233b; --green: #16845b; --red: #c2413b; --shadow: 0 8px 24px rgba(28, 52, 84, .06); }
        * { box-sizing: border-box; }
        body { margin: 0; color: var(--ink); background: var(--paper); font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
        a { color: inherit; text-decoration: none; }
        button, input, textarea, select { font: inherit; }
        .shell { display: flex; min-height: 100vh; }
        .nav { width: 238px; flex: 0 0 238px; padding: 28px 18px; color: #cad5e5; background: var(--navy); }
        .brand { display: flex; align-items: center; gap: 11px; margin: 0 10px 52px; color: #fff; font-size: 1.2rem; font-weight: 800; letter-spacing: -.02em; }
        .brand-mark { display: grid; place-items: center; width: 33px; height: 33px; color: white; background: var(--blue); border-radius: 8px; font-weight: 800; }
        .nav-note { display: block; margin: 0 12px 12px; color: #7f91aa; font-size: .66rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; }
        .nav-link { display: flex; align-items: center; gap: 10px; margin: 4px 0; padding: 12px; border-radius: 7px; color: #aebbd0; font-size: .88rem; font-weight: 600; }
        .nav-link.active, .nav-link:hover { color: #fff; background: rgba(65, 112, 188, .28); }
        .nav-icon { width: 20px; color: #73a4ff; text-align: center; font-weight: 800; }
        main { width: min(1160px, calc(100% - 238px)); padding: 34px 46px 70px; }
        .topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 48px; }
        .topbar-label { color: var(--muted); font-size: .78rem; font-weight: 600; }
        .user-badge { display: flex; align-items: center; gap: 9px; color: var(--muted); font-size: .8rem; }
        .avatar { display: grid; place-items: center; width: 30px; height: 30px; color: #fff; background: #f59e0b; border-radius: 50%; font-size: .76rem; font-weight: 800; }
        .eyebrow { margin-bottom: 8px; color: var(--blue); font-size: .7rem; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; }
        h1 { margin: 0 0 8px; font-size: 2rem; line-height: 1.2; letter-spacing: -.04em; }
        .intro { max-width: 600px; margin: 0; color: var(--muted); font-size: .92rem; line-height: 1.55; }
        .page-head { display: flex; align-items: end; justify-content: space-between; gap: 24px; margin-bottom: 30px; }
        .button { display: inline-flex; align-items: center; justify-content: center; border: 0; padding: 11px 16px; color: white; background: var(--blue); border-radius: 6px; cursor: pointer; font-size: .82rem; font-weight: 700; }
        .button:hover { background: var(--blue-dark); }
        .button.secondary { color: var(--ink); background: #e8eef8; }
        .button.danger { color: var(--red); background: #fce8e7; }
        .stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 28px; }
        .stat { padding: 19px 21px; border: 1px solid var(--line); border-radius: 8px; background: var(--surface); box-shadow: var(--shadow); }
        .stat strong { display: block; margin-bottom: 5px; color: var(--ink); font-size: 1.65rem; }
        .stat span { color: var(--muted); font-size: .7rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; }
        .flash { margin-bottom: 22px; padding: 13px 16px; border: 1px solid #b9e5d2; border-radius: 6px; color: #126342; background: #ecfbf4; font-size: .86rem; }
        .task-list { overflow: hidden; border: 1px solid var(--line); border-radius: 8px; background: var(--surface); box-shadow: var(--shadow); }
        .task { display: grid; grid-template-columns: minmax(0, 1fr) auto; gap: 24px; align-items: center; padding: 18px 22px; border-bottom: 1px solid var(--line); }
        .task:last-child { border-bottom: 0; }
        .task h2 { margin: 0 0 6px; font-size: .98rem; }
        .task p { margin: 0 0 10px; color: var(--muted); font-size: .82rem; line-height: 1.45; }
        .meta { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; color: var(--muted); font-size: .73rem; }
        .pill { display: inline-block; padding: 4px 8px; border-radius: 12px; color: var(--green); background: #e7f7ef; font-size: .68rem; font-weight: 800; }
        .pill.completed { color: #956b00; background: #fff4cf; }
        .actions { display: flex; align-items: center; gap: 6px; }
        .actions form { margin: 0; }
        .icon-link { padding: 7px; color: var(--blue); font-size: .78rem; font-weight: 700; }
        .icon-link:hover { text-decoration: underline; }
        .empty { padding: 58px 24px; border: 1px dashed #b9c9dc; border-radius: 8px; background: var(--surface); text-align: center; }
        .empty h2 { margin: 0 0 8px; font-size: 1.2rem; }
        .empty p { margin: 0 0 20px; color: var(--muted); font-size: .88rem; }
        .form-card { max-width: 720px; padding: 28px; border: 1px solid var(--line); border-radius: 8px; background: var(--surface); box-shadow: var(--shadow); }
        .form-card h2 { margin: 0 0 24px; font-size: 1.25rem; }
        .field { margin-bottom: 18px; }
        label { display: block; margin-bottom: 7px; color: #52627a; font-size: .72rem; font-weight: 800; letter-spacing: .05em; text-transform: uppercase; }
        input, textarea, select { width: 100%; border: 1px solid #d5deea; border-radius: 5px; padding: 11px 12px; color: var(--ink); background: #fbfcfe; font-size: .88rem; }
        textarea { min-height: 120px; resize: vertical; }
        input:focus, textarea:focus, select:focus { outline: 2px solid #bfdbfe; border-color: var(--blue); }
        .errors { margin: 0 0 20px; padding: 12px 16px; border-radius: 5px; color: var(--red); background: #fce8e7; font-size: .84rem; }
        .errors ul { margin: 0; padding-left: 18px; }
        .form-actions { display: flex; gap: 10px; margin-top: 25px; }
        @media (max-width: 760px) { .shell { display: block; } .nav { width: 100%; padding: 16px; } .brand { margin: 0 0 16px; } .nav-note { display: none; } .nav-link { display: inline-flex; margin-right: 4px; padding: 9px 10px; } main { width: 100%; padding: 28px 18px 50px; } .topbar { margin-bottom: 30px; } }
        @media (max-width: 560px) { .user-badge { display: none; } .page-head { display: block; } .page-head .button { margin-top: 20px; } .stats { gap: 8px; } .stat { padding: 14px 10px; } .stat strong { font-size: 1.35rem; } .stat span { font-size: .6rem; } .task { grid-template-columns: 1fr; gap: 13px; } .actions { justify-content: flex-start; } }
    </style>
</head>
<body>
<div class="shell">
    <header class="nav">
        <a class="brand" href="{{ route('tasks.index') }}"><span class="brand-mark">✓</span> TaskBoard</a>
        <span class="nav-note">Workspace</span>
        <a class="nav-link active" href="{{ route('tasks.index') }}"><span class="nav-icon">▦</span> All tasks</a>
        <a class="nav-link" href="{{ route('tasks.create') }}"><span class="nav-icon">+</span> Add new task</a>
    </header>
    <main>
        <div class="topbar">
            <span class="topbar-label">Personal task manager / Dashboard</span>
            <div class="user-badge"><span class="avatar">ST</span> Student workspace</div>
        </div>
        @yield('content')
    </main>
</div>
</body>
</html>
