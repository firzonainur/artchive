<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearningMaterial extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image_path',
        'file_path',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];
}
