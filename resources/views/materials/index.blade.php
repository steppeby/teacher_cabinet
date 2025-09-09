@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Материалы</h1>

    @if(session('success'))
        <div style="background:#e6ffed;padding:8px;margin-bottom:10px">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('materials.index') }}" style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px">
        <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Поиск по названию/описанию">
        <select name="category">
            <option value="">Все категории</option>
            @foreach (['lecture'=>'Лекции','practice'=>'Практики','exam'=>'Экзамены'] as $val => $label)
                <option value="{{ $val }}" @selected(($category ?? '')===$val)>{{ $label }}</option>
            @endforeach
        </select>
        <input type="date" name="from" value="{{ $from ? \Illuminate\Support\Carbon::parse($from)->toDateString() : '' }}">
        <input type="date" name="to" value="{{ $to ? \Illuminate\Support\Carbon::parse($to)->toDateString() : '' }}">
        <button type="submit">Фильтр</button>
        <a href="{{ route('materials.create') }}">+ Добавить</a>
    </form>

    <table border="1" cellpadding="6" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Название</th>
                <th>Категория</th>
                <th>Загружен</th>
                <th>Файл</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @forelse($materials as $m)
            @php $media = $m->getFirstMedia('materials'); @endphp
            <tr>
                <td>{{ $m->title }}</td>
                <td>{{ $m->category }}</td>
                <td>{{ $m->created_at?->format('Y-m-d H:i') }}</td>
                <td>
                    @if($media)
                        <a href="{{ $media->getUrl() }}" target="_blank">Открыть</a>
                        |
                        <a href="{{ route('materials.download', [$m->id, $media->id]) }}">Скачать</a>
                    @else
                        —
                    @endif
                </td>
                <td>
                    <a href="{{ route('materials.show', $m) }}">Просмотр</a> |
                    <a href="{{ route('materials.edit', $m) }}">Править</a>
                    <form action="{{ route('materials.destroy', $m) }}" method="POST" style="display:inline"
                          onsubmit="return confirm('Удалить материал?')">
                        @csrf @method('DELETE')
                        <button type="submit">Удалить</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">Ничего не найдено</td></tr>
        @endforelse
        </tbody>
    </table>

    <div style="margin-top:10px">
        {{ $materials->links() }}
    </div>
</div>
@endsection
