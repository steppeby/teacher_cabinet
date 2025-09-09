@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Просмотр расписания</h1>

    <p><strong>Дата:</strong> {{ $schedule->date }}</p>
    <p><strong>Начало:</strong> {{ $schedule->start_time }}</p>
    <p><strong>Конец:</strong> {{ $schedule->end_time }}</p>
    <p><strong>Аудитория:</strong> {{ $schedule->auditorium }}</p>
    <p><strong>Группа:</strong> {{ $schedule->group }}</p>

    <div style="margin-top:15px;">
        <a href="{{ route('schedules.index') }}">⬅ Назад</a>
    </div>
</div>
@endsection
