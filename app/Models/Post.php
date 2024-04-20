<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    //    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'image'
    ];

    public function setImageAttribute($value): void
    {
        $this->attributes['image'] = Storage::disk('public')->put('images', $value);
    }
}
