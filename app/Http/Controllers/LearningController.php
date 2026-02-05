<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LearningController extends Controller
{
    public function index()
    {
        $materials = \App\Models\LearningMaterial::where('is_published', true)
            ->latest()
            ->paginate(9);
            
        return view('learning.index', compact('materials'));
    }

    public function show($slug)
    {
        $material = \App\Models\LearningMaterial::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
            
        return view('learning.show', compact('material'));
    }
}
