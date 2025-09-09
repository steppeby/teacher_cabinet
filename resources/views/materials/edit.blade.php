@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Редактировать материал</h1>

    @if ($errors->any())
        <div style="background:#fee2e2;padding:8px;margin-bottom:10px">
            <ul style="margin:0">
                @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('materials.update', $material) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div>
            <label>Название</label><br>
            <input type="text" name="title" value="{{ old('title',$material->title) }}" required>
        </div>

        <div>
            <label>Категория</label><br>
            <select name="category" required>
                @foreach(['lecture'=>'Лекции','practice'=>'Практики','exam'=>'Экзамены'] as $val=>$label)
                    <option value="{{ $val }}" @selected($material->category===$val)>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Описание</label><br>
            <textarea name="description" rows="4">{{ old('description',$material->description) }}</textarea>
        </div>

        <div>
            <label>Заменить файл (необязательно)</label><br>
            <input type="file" name="file">
        </div>

        <button type="submit">Сохранить</button>
        <a href="{{ route('materials.show', $material) }}">Отмена</a>
    </form>
</div>
@endsection
