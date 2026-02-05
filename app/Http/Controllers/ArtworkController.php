<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Category;
use App\Models\Technique;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArtworkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Artwork::with(['user', 'category'])
            ->where('status', 'published');

        // Filters
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $artworks = $query->latest()->paginate(12);
        $categories = Category::all();
        $techniques = Technique::all();
        $institutions = Institution::all();

        return view('artworks.index', compact('artworks', 'categories', 'techniques', 'institutions'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View // Using ID for simplicity, typically slug
    {
        $artwork = Artwork::with(['user', 'category', 'technique', 'institution', 'publications', 'comments.user'])
            ->findOrFail($id);
            
        return view('artworks.show', compact('artwork'));
    }

    public function storeComment(Request $request, Artwork $artwork)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $artwork->comments()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        return back()->with('success', 'Comment posted successfully.');
    }
}
