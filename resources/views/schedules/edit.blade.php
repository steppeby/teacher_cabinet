<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Редактировать расписание</title>
</head>
<body>
    <h1>Редактировать расписание</h1>

    @if($errors->any())
        <div style="color:red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('schedules.update', $schedule) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Дата:
            <input type="date" name="date" value="{{ old('date', $schedule->date) }}">
        </label><br><br>
        <label>Начало:
            <input type="time" name="start_time" value="{{ old('start_time', $schedule->start_time) }}">
        </label><br><br>
        <label>Конец:
            <input type="time" name="end_time" value="{{ old('end_time', $schedule->end_time) }}">
        </label><br><br>
        <label>Аудитория:
            <input type="text" name="auditorium" value="{{ old('auditorium', $schedule->auditorium) }}">
        </label><br><br>
        <label>Группа:
            <input type="text" name="group" value="{{ old('group', $schedule->group) }}">
        </label><br><br>
        <button type="submit">💾 Обновить</button>
    </form>

    <br>
    <a href="{{ route('schedules.index') }}">⬅ Назад</a>
</body>
</html>
