@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $material->title }}</h1>
    <p><b>Категория:</b> {{ $material->category }}</p>
    <p>{{ $material->description }}</p>

    @if($media)
        <p>
            <a href="{{ $media->getUrl() }}" target="_blank">Открыть</a> |
            <a href="{{ route('materials.download', [$material->id, $media->id]) }}">Скачать</a>
        </p>
    @else
        <p>Файл не прикреплён.</p>
    @endif

    <p>
        <a href="{{ route('materials.edit', $material) }}">Редактировать</a> |
        <a href="{{ route('materials.index') }}">Назад</a>
    </p>
</div>
@endsection
