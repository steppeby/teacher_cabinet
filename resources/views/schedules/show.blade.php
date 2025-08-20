<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Просмотр расписания</title>
</head>
<body>
    <h1>Просмотр расписания</h1>

    <p><strong>Дата:</strong> {{ $schedule->date }}</p>
    <p><strong>Начало:</strong> {{ $schedule->start_time }}</p>
    <p><strong>Конец:</strong> {{ $schedule->end_time }}</p>
    <p><strong>Аудитория:</strong> {{ $schedule->auditorium }}</p>
    <p><strong>Группа:</strong> {{ $schedule->group }}</p>

    <a href="{{ route('schedules.index') }}">⬅ Назад</a>
</body>
</html>
