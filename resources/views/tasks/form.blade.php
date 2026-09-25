<div class="field">
    <label for="task_name">Task name</label>
    <input id="task_name" name="task_name" type="text" value="{{ old('task_name', $task->task_name ?? '') }}" required autofocus>
</div>
<div class="field">
    <label for="description">Description <span style="font-weight: normal; text-transform: none; letter-spacing: 0;">(optional)</span></label>
    <textarea id="description" name="description">{{ old('description', $task->description ?? '') }}</textarea>
</div>
<div class="field">
    <label for="status">Status</label>
    <select id="status" name="status" required>
        @foreach (['Pending', 'Completed'] as $status)
            <option value="{{ $status }}" @selected(old('status', $task->status ?? 'Pending') === $status)>{{ $status }}</option>
        @endforeach
    </select>
</div>
<div class="field">
    <label for="due_date">Due date <span style="font-weight: normal; text-transform: none; letter-spacing: 0;">(optional)</span></label>
    <input id="due_date" name="due_date" type="date" value="{{ old('due_date', isset($task) && $task->due_date ? $task->due_date->format('Y-m-d') : '') }}">
</div>
