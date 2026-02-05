<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Artwork;
use App\Models\Category;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Models\Publication;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function analytics(): View
    {
        $sixMonthsAgo = Carbon::now()->subMonths(6);

        // Fetch data (filtered by date)
        $users = User::select('created_at')
            ->where('created_at', '>=', $sixMonthsAgo)
            ->get();

        $artworks = Artwork::select('created_at')
            ->where('created_at', '>=', $sixMonthsAgo)
            ->get();

        $publications = Publication::select('created_at')
            ->where('created_at', '>=', $sixMonthsAgo)
            ->get();
            
        $visits = Visit::select('created_at')
            ->where('created_at', '>=', $sixMonthsAgo)
            ->get();
            
        // Categories Distribution
        $categoryStats = Category::withCount('artworks')->get();

        // Prepare labels (last 6 months)
        $labels = [];
        for ($i = 5; $i >= 0; $i--) {
            $labels[] = Carbon::now()->subMonths($i)->format('M Y');
        }

        // Helper to map collection data to labels
        $mapData = function($collection) use ($labels) {
            // Group by "M Y" e.g., "Jan 2025"
            $grouped = $collection->groupBy(function($item) {
                return $item->created_at->format('M Y');
            })->map->count();

            // Align with labels
            $data = [];
            foreach ($labels as $label) {
                $data[] = $grouped->get($label, 0);
            }
            return $data;
        };

        $chartData = [
            'labels' => $labels,
            'users' => $mapData($users),
            'artworks' => $mapData($artworks),
            'publications' => $mapData($publications),
            'visits' => $mapData($visits),
            'categories' => [
                'labels' => $categoryStats->pluck('name'),
                'data' => $categoryStats->pluck('artworks_count')
            ]
        ];

        return view('admin.analytics', compact('chartData'));
    }
    public function gallery(): View
    {
        $artworks = Artwork::latest()->paginate(24);
        return view('admin.gallery', compact('artworks'));
    }

    public function index(): View
    {
        $today = Carbon::today();
        $limitDate = Carbon::now()->subDays(6)->startOfDay();

        // 1. Stats
        $stats = [
            'total_visits' => Visit::count(),
            'total_visits_today' => Visit::whereDate('created_at', $today)->count(),
            'unique_visitors_today' => Visit::whereDate('created_at', $today)->distinct('ip_address')->count('ip_address'),
            'projects' => Artwork::count(),
            'articles' => \App\Models\LearningMaterial::count(), // Assuming LearningMaterial is what user means by "Articles"
        ];

        // 2. Visitor Traffic Chart (Last 7 Days)
        $trafficData = Visit::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', $limitDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Fill in missing days with 0
        $trafficLabels = [];
        $trafficCounts = [];
        $currentDate = clone $limitDate;
        
        while ($currentDate <= Carbon::now()->startOfDay()) {
            $dateString = $currentDate->format('Y-m-d');
            $record = $trafficData->firstWhere('date', $dateString);
            
            $trafficLabels[] = $currentDate->format('M d');
            $trafficCounts[] = $record ? $record->count : 0;
            
            $currentDate->addDay();
        }

        // 3. Top Visited Pages
        $topPages = Visit::select('url', DB::raw('count(*) as count'))
            ->groupBy('url')
            ->orderByDesc('count')
            ->take(5)
            ->get()
            ->map(function ($visit) {
                // Formatting URL to be cleaner (e.g. removing the domain if desired, or keep as is)
                $visit->path = str_replace(url('/'), '', $visit->url);
                if ($visit->path === '') $visit->path = '/';
                return $visit;
            });

        return view('admin.index', compact('stats', 'trafficLabels', 'trafficCounts', 'topPages'));
    }

    public function manageArtworks(): View
    {
        $artworks = Artwork::with('user')->latest()->paginate(20);
        return view('admin.artworks', compact('artworks'));
    }

    public function manageUsers(): View
    {
        $users = User::latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function approveArtwork(Artwork $artwork)
    {
        $artwork->update(['status' => 'published']);
        return back()->with('success', 'Artwork approved successfully.');
    }

    public function destroyArtwork(Artwork $artwork)
    {
        $artwork->delete();
        return back()->with('success', 'Artwork deleted successfully.');
    }

    public function settings(): View
    {
        $chatbotEnabled = \App\Models\Setting::where('key', 'chatbot_enabled')->value('value') === 'true';
        return view('admin.settings', compact('chatbotEnabled'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'chatbot_enabled' => 'nullable|in:on,off',
        ]);

        $enabled = $request->input('chatbot_enabled') === 'on' ? 'true' : 'false';

        \App\Models\Setting::updateOrCreate(
            ['key' => 'chatbot_enabled'],
            ['value' => $enabled]
        );

        // Return JSON if AJAX request
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Settings updated successfully.'
            ]);
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}
