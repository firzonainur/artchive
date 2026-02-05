<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Institution extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'location', 'website', 'logo', 'description'];

    public function artworks(): HasMany
    {
        return $this->hasMany(Artwork::class);
    }
}
