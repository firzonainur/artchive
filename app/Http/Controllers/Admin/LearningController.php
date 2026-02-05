<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LearningController extends Controller
{
    public function index()
    {
        $materials = \App\Models\LearningMaterial::latest()->paginate(10);
        return view('admin.learning.index', compact('materials'));
    }

    public function create()
    {
        return view('admin.learning.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048', // 2MB Max
            'file' => 'nullable|file|max:10240', // 10MB Max
            'is_published' => 'boolean'
        ]);

        $slug = \Illuminate\Support\Str::slug($validated['title']);
        
        // Handle Image Upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('learning-images', 'public');
        }

        // Handle File Upload
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('learning-files', 'public');
        }

        \App\Models\LearningMaterial::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'content' => $validated['content'],
            'image_path' => $imagePath,
            'file_path' => $filePath,
            'is_published' => $request->has('is_published')
        ]);

        return redirect()->route('admin.learning.index')->with('success', 'Materi berhasil dibuat.');
    }

    public function edit(\App\Models\LearningMaterial $learning)
    {
        return view('admin.learning.edit', compact('learning'));
    }

    public function update(Request $request, \App\Models\LearningMaterial $learning)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'file' => 'nullable|file|max:10240',
            'is_published' => 'boolean'
        ]);

        $learning->title = $validated['title'];
        // Update slug if needed, usually we keep it or check uniqueness
        // $learning->slug = \Illuminate\Support\Str::slug($validated['title']);
        $learning->content = $validated['content'];
        $learning->is_published = $request->has('is_published');

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($learning->image_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($learning->image_path);
            }
            $learning->image_path = $request->file('image')->store('learning-images', 'public');
        }

        if ($request->hasFile('file')) {
            if ($learning->file_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($learning->file_path);
            }
            $learning->file_path = $request->file('file')->store('learning-files', 'public');
        }

        $learning->save();

        return redirect()->route('admin.learning.index')->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy(\App\Models\LearningMaterial $learning)
    {
        if ($learning->image_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($learning->image_path);
        }
        if ($learning->file_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($learning->file_path);
        }
        
        $learning->delete();
        return redirect()->route('admin.learning.index')->with('success', 'Materi berhasil dihapus.');
    }
}
