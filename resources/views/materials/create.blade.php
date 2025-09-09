@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Новый материал</h1>

    @if ($errors->any())
        <div style="background:#fee2e2;padding:8px;margin-bottom:10px">
            <ul style="margin:0">
                @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('materials.store') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <label>Название</label><br>
            <input type="text" name="title" value="{{ old('title') }}" required>
        </div>

        <div>
            <label>Категория</label><br>
            <select name="category" required>
                <option value="lecture">Лекции</option>
                <option value="practice">Практики</option>
                <option value="exam">Экзамены</option>
            </select>
        </div>

        <div>
            <label>Описание</label><br>
            <textarea name="description" rows="4">{{ old('description') }}</textarea>
        </div>

        <div>
            <label>Файл</label><br>
            <input type="file" name="file" required>
            <small>pdf/doc/docx/ppt/xls/zip/jpg/png … (до 25MB)</small>
        </div>

        <button type="submit">Загрузить</button>
        <a href="{{ route('materials.index') }}">Отмена</a>
    </form>
</div>
@endsection
