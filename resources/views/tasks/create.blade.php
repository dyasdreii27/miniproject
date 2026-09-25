@extends('layouts.app')

@section('content')
<div class="eyebrow">New task</div>
<h1>Make it concrete.</h1>
<p class="intro" style="margin-bottom: 32px;">Name the next thing clearly, then choose when you want it off your mind.</p>

<div class="form-card">
    <h2>Add a task</h2>
    @if ($errors->any())
        <div class="errors"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf
        @include('tasks.form')
        <div class="form-actions">
            <button class="button" type="submit">Save task</button>
            <a class="button secondary" href="{{ route('tasks.index') }}">Cancel</a>
        </div>
    </form>
</div>
@endsection
