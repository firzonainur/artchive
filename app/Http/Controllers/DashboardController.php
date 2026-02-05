<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Category;
use App\Models\Technique;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    /**
     * Show the user dashboard.
     */
    public function index(): View
    {
        $user = Auth::user();
        $artworks = $user->artworks()->latest()->paginate(10);
        $favorites = $user->favorites()->latest()->take(5)->get();

        return view('dashboard', compact('user', 'artworks', 'favorites'));
    }

    /**
     * Show the form for creating a new artwork.
     */
    public function createArtwork(): View
    {
        $categories = Category::all();
        $techniques = Technique::all();
        $institutions = Institution::all();

        return view('dashboard.artworks.create', compact('categories', 'techniques', 'institutions'));
    }

    /**
     * Store a newly created artwork in storage.
     */
    public function storeArtwork(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|max:10240', // 10MB max
            'year' => 'nullable|string|max:4',
        ]);

        $path = $request->file('image')->store('artworks', 'public');

        Auth::user()->artworks()->create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(4),
            'category_id' => $request->category_id,
            'technique_id' => $request->technique_id,
            'institution_id' => $request->institution_id,
            'year' => $request->year,
            'dimensions' => $request->dimensions,
            'description' => $request->description,
            'image_path' => $path,
            'status' => 'draft', // Default to draft
        ]);

        return redirect()->route('dashboard')->with('success', 'Artwork uploaded successfully.');
    }

    public function editArtwork(Artwork $artwork): View
    {
        if (Auth::id() !== $artwork->user_id) {
            abort(403);
        }

        $categories = Category::all();
        $techniques = Technique::all();
        $institutions = Institution::all();

        return view('dashboard.artworks.edit', compact('artwork', 'categories', 'techniques', 'institutions'));
    }

    public function updateArtwork(Request $request, Artwork $artwork): RedirectResponse
    {
        if (Auth::id() !== $artwork->user_id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:10240', // Optional on update
            'year' => 'nullable|string|max:4',
        ]);

        $data = [
            'title' => $request->title,
            'category_id' => $request->category_id,
            'technique_id' => $request->technique_id,
            'institution_id' => $request->institution_id,
            'year' => $request->year,
            'dimensions' => $request->dimensions,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            // Delete old image if exists? (Optional, good practice)
            if ($artwork->image_path) {
                Storage::disk('public')->delete($artwork->image_path);
            }
            $data['image_path'] = $request->file('image')->store('artworks', 'public');
        }

        $artwork->update($data);

        return redirect()->route('dashboard')->with('success', 'Artwork updated successfully.');
    }
}
