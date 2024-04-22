<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'image'
    ];

    public function setImageAttribute($value): void
    {
        $disk = app()->environment('testing')
            ? Storage::fake('public')
            : Storage::disk('public');

        if ($this->image) {
            $disk->delete($this->image);
        }

        $this->attributes['image'] = $disk->put('images', $value);
    }
}
