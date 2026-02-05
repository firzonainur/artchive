<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Show the landing page with featured artworks and categories.
     */
    public function index(): View
    {
        $featuredArtworks = Artwork::with('user')
            ->where('status', 'published')
            ->where('is_featured', true)
            ->latest()
            ->take(6)
            ->get();

        $categories = Category::all();

        $latestArtworks = Artwork::with('user')
            ->where('status', 'published')
            ->latest()
            ->take(8)
            ->get();

        return view('welcome', compact('featuredArtworks', 'categories', 'latestArtworks'));
    }

    public function virtualExhibition(): View
    {
        $artworks = Artwork::where('status', 'published')
            ->whereNotNull('image_path')
            ->latest()
            ->take(10)
            ->get();
            
        return view('virtual-exhibition', compact('artworks'));
    }
}
