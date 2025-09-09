<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        // $this->middleware(['role:teacher|methodist|admin']); // включи, когда роли будут готовы
    }

    /**
     * Список + поиск/фильтр
     */
    public function index(Request $request)
    {
        $q        = $request->input('q');
        $category = $request->input('category');
        $from     = $request->input('from');
        $to       = $request->input('to');

        $materials = Material::query()
            ->when($q, fn($qb) =>
                $qb->where(function ($sub) use ($q) {
                    $sub->where('title', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%");
                })
            )
            ->when($category, fn($qb) => $qb->where('category', $category))
            ->when($from, fn($qb) => $qb->whereDate('created_at', '>=', $from))
            ->when($to, fn($qb) => $qb->whereDate('created_at', '<=', $to))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('materials.index', compact('materials', 'q', 'category', 'from', 'to'));
    }

    public function create()
    {
        return view('materials.create');
    }

    /**
     * Загрузка файла + создание карточки
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => ['required','string','max:255'],
            'category'    => ['required','in:lecture,practice,exam'],
            'description' => ['nullable','string'],
            'file'        => ['required','file','max:25600',
                              'mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt,zip,rar,7z,png,jpg,jpeg'],
        ]);

        $material = Material::create([
            'user_id'    => Auth::id(),
            'title'      => $validated['title'],
            'category'   => $validated['category'],
            'description'=> $validated['description'] ?? null,
        ]);

        $this->saveFile($material, $request, $validated['title']);

        return redirect()->route('materials.index')->with('success', 'Материал загружен');
    }

    public function show(Material $material)
    {
        $media = $material->getFirstMedia('materials');
        return view('materials.show', compact('material', 'media'));
    }

    public function edit(Material $material)
    {
        return view('materials.edit', compact('material'));
    }

    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'title'       => ['required','string','max:255'],
            'category'    => ['required','in:lecture,practice,exam'],
            'description' => ['nullable','string'],
            'file'        => ['nullable','file','max:25600',
                              'mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt,zip,rar,7z,png,jpg,jpeg'],
        ]);

        $material->update([
            'title'       => $validated['title'],
            'category'    => $validated['category'],
            'description' => $validated['description'] ?? null,
        ]);

        if ($request->hasFile('file')) {
            $material->clearMediaCollection('materials');
            $this->saveFile($material, $request, $validated['title']);
        }

        return redirect()->route('materials.show', $material)->with('success', 'Материал обновлён');
    }

    public function destroy(Material $material)
    {
        $material->delete();
        return redirect()->route('materials.index')->with('success', 'Материал удалён');
    }

    /**
     * Скачивание файла
     */
    public function download(Material $material, Media $media)
    {
        abort_unless(
            $media->model_id === $material->id && $media->model_type === Material::class,
            404
        );

        return response()->download($media->getPath(), $media->file_name);
    }

    /**
     * Сохранение файла через Spatie
     */
    protected function saveFile(Material $material, Request $request, string $title): void
    {
        $file = $request->file('file');
        $material->addMedia($file)
            ->usingFileName($this->safeFileName($title, $file->getClientOriginalExtension()))
            ->toMediaCollection('materials');
    }

    /**
     * Генерация безопасного имени файла
     */
    protected function safeFileName(string $title, string $ext): string
    {
        $slug = str()->slug($title);
        return $slug.'-'.now()->format('YmdHis').'.'.$ext;
    }
}
