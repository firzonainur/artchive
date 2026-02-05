<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ResearchController extends Controller
{
    /**
     * Display a listing of the resource (Public).
     */
    public function index(Request $request)
    {
        $query = Publication::with('user');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('abstract', 'like', "%{$search}%");
            });
        }

        // Sort
        if ($request->input('sort') === 'oldest') {
            $query->oldest('published_date');
        } else {
            $query->latest('published_date');
        }

        $publications = $query->paginate(9)->withQueryString();
        return view('research.index', compact('publications'));
    }

    /**
     * Display the specified resource (Public).
     */
    public function show($slug)
    {
        $publication = Publication::where('slug', $slug)->with(['user', 'artworks'])->firstOrFail();
        return view('research.show', compact('publication'));
    }

    /**
     * Show the form for creating a new resource (Dashboard).
     */
    public function create()
    {
        $artworks = Artwork::select('id', 'title')->get();
        return view('dashboard.research.create', compact('artworks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'required|string',
            'publication_file' => 'nullable|file|mimes:pdf|max:10240', // 10MB PDF
            'external_link' => 'nullable|url',
            'published_date' => 'nullable|date',
            'artworks' => 'nullable|array',
            'artworks.*' => 'exists:artworks,id',
        ]);

        $filePath = null;
        if ($request->hasFile('publication_file')) {
            $filePath = $request->file('publication_file')->store('publications', 'public');
        }

        $publication = Publication::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(5),
            'abstract' => $request->abstract,
            'file_path' => $filePath,
            'external_link' => $request->external_link,
            'published_date' => $request->published_date ?? now(),
        ]);

        if ($request->has('artworks')) {
            $publication->artworks()->attach($request->artworks);
        }

        return redirect()->route('research.index')->with('success', 'Research published successfully.');
    }
}
