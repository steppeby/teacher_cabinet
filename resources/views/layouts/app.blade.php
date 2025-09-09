<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>@yield('title','Кабинет преподавателя')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="font-family:system-ui,Arial,sans-serif;margin:20px">
    <nav style="margin-bottom:12px">
        <a href="{{ url('/') }}">Главная</a> |
        <a href="{{ route('materials.index') }}">Материалы</a> |
        <a href="{{ route('schedules.index') }}">Расписания</a>
    </nav>
    @yield('content')
</body>
</html>
