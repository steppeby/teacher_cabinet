@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Список расписаний</h1>

    <a href="{{ route('schedules.create') }}">➕ Добавить</a> |
    <a href="{{ route('schedules.exportExcel') }}">⬇ Экспорт в Excel</a>

    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Дата</th>
                <th>Начало</th>
                <th>Конец</th>
                <th>Аудитория</th>
                <th>Группа</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
        @forelse($schedules as $schedule)
            <tr>
                <td>{{ $schedule->date }}</td>
                <td>{{ $schedule->start_time }}</td>
                <td>{{ $schedule->end_time }}</td>
                <td>{{ $schedule->auditorium }}</td>
                <td>{{ $schedule->group }}</td>
                <td>
                    <a href="{{ route('schedules.show', $schedule) }}">👁 Просмотр</a> |
                    <a href="{{ route('schedules.edit', $schedule) }}">✏ Редактировать</a>
                    <form action="{{ route('schedules.destroy', $schedule) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Удалить запись?')">🗑 Удалить</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6">Нет данных</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
