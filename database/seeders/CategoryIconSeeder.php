<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryIconSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure directory exists
        if (!Storage::disk('public')->exists('category-icons')) {
            Storage::disk('public')->makeDirectory('category-icons');
        }

        $categories = Category::all();

        $gradients = [
            ['#ef4444', '#b91c1c'], // Red
            ['#f97316', '#c2410c'], // Orange
            ['#f59e0b', '#b45309'], // Amber
            ['#84cc16', '#4d7c0f'], // Lime
            ['#10b981', '#047857'], // Emerald
            ['#06b6d4', '#0e7490'], // Cyan
            ['#3b82f6', '#1d4ed8'], // Blue
            ['#8b5cf6', '#6d28d9'], // Violet
            ['#d946ef', '#a21caf'], // Fuchsia
            ['#f43f5e', '#be123c'], // Rose
        ];

        foreach ($categories as $index => $category) {
            $initial = substr($category->name, 0, 1);
            $colors = $gradients[$index % count($gradients)];
            $color1 = $colors[0];
            $color2 = $colors[1];

            // Generate simple SVG Icon
            $svg = <<<SVG
<svg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
    <defs>
        <linearGradient id="grad_{$index}" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:{$color1};stop-opacity:1" />
            <stop offset="100%" style="stop-color:{$color2};stop-opacity:1" />
        </linearGradient>
    </defs>
    <rect width="100" height="100" rx="20" fill="url(#grad_{$index})" />
    <text x="50" y="50" font-family="Arial, sans-serif" font-size="50" font-weight="bold" fill="white" text-anchor="middle" dy=".35em">{$initial}</text>
</svg>
SVG;

            $filename = 'category-icons/' . $category->slug . '.svg';
            Storage::disk('public')->put($filename, $svg);

            $category->update(['icon' => $filename]);
            
            $this->command->info("Generated icon for {$category->name}");
        }
    }
}
