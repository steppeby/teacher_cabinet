<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Material extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'user_id','title','category','description',
    ];

    // опционально: коллекция с именем 'materials'
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('materials')
             ->useFallbackUrl('/images/file-placeholder.png'); // если хочешь плейсхолдер
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
