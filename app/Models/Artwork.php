<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Artwork extends Model
{
    use HasFactory, SoftDeletes;
    
    protected static function booted()
    {
        static::creating(function ($artwork) {
            if (empty($artwork->slug)) {
                $artwork->slug = \Illuminate\Support\Str::slug($artwork->title);
            }
        });
    }

    protected $fillable = [
        'user_id',
        'category_id',
        'technique_id',
        'institution_id',
        'title',
        'slug',
        'year',
        'dimensions',
        'description',
        'image_path',
        'gallery_images',
        'status',
        'is_featured'
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'is_featured' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function technique(): BelongsTo
    {
        return $this->belongsTo(Technique::class);
    }

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }

    public function publications(): BelongsToMany
    {
        return $this->belongsToMany(Publication::class, 'artwork_publication');
    }

    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
