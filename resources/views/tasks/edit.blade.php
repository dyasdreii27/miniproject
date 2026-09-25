@extends('layouts.app')

@section('content')
<div class="eyebrow">Edit task</div>
<h1>Keep it moving.</h1>
<p class="intro" style="margin-bottom: 32px;">Update the details below and keep your list honest.</p>

<div class="form-card">
    <h2>Update task</h2>
    @if ($errors->any())
        <div class="errors"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
    <form method="POST" action="{{ route('tasks.update', $task) }}">
        @csrf
        @method('PUT')
        @include('tasks.form', ['task' => $task])
        <div class="form-actions">
            <button class="button" type="submit">Update task</button>
            <a class="button secondary" href="{{ route('tasks.index') }}">Cancel</a>
        </div>
    </form>
</div>
@endsection
