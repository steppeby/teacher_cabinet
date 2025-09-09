@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Редактировать расписание</h1>

    @if($errors->any())
        <div style="color:red; margin-bottom:10px;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('schedules.update', $schedule) }}" method="POST" style="display:flex;flex-direction:column;gap:10px;max-width:400px;">
        @csrf
        @method('PUT')

        <label>Дата:
            <input type="date" name="date" value="{{ old('date', $schedule->date) }}">
        </label>

        <label>Начало:
            <input type="time" name="start_time" value="{{ old('start_time', $schedule->start_time) }}">
        </label>

        <label>Конец:
            <input type="time" name="end_time" value="{{ old('end_time', $schedule->end_time) }}">
        </label>

        <label>Аудитория:
            <input type="text" name="auditorium" value="{{ old('auditorium', $schedule->auditorium) }}">
        </label>

        <label>Группа:
            <input type="text" name="group" value="{{ old('group', $schedule->group) }}">
        </label>

        <button type="submit">💾 Обновить</button>
    </form>

    <div style="margin-top:15px;">
        <a href="{{ route('schedules.index') }}">⬅ Назад</a>
    </div>
</div>
@endsection
