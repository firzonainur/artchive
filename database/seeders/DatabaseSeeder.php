<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Technique;
use App\Models\Institution;
use App\Models\Artwork;
use App\Models\Publication;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Categories
        $categories = [
            'Visual Arts', 'Digital Media', 'Sculpture', 'Photography', 
            'Performance Art', 'Installation', 'Mixed Media', 'Architecture'
        ];
        
        foreach ($categories as $cat) {
            Category::create(['name' => $cat, 'slug' => Str::slug($cat)]);
        }

        // 2. Create Techniques
        $techniques = [
            'Oil on Canvas', 'Acrylic', 'Watercolor', '3D Rendering', 
            'Generative Adversarial Networks (GAN)', 'Bronze Casting', 
            'Laser Cutting', 'Projection Mapping'
        ];

        foreach ($techniques as $tech) {
            Technique::create(['name' => $tech, 'slug' => Str::slug($tech)]);
        }

        // 3. Create Institutions
        $this->call(InstitutionSeeder::class);

        // 4. Create Users (Admin, Researchers, Students)
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
            'bio' => 'System Administrator and Curator.',
        ]);

        User::factory(5)->create([
            'role' => 'researcher',
            'institution' => 'MIT Media Lab',
        ]);

        User::factory(10)->create([
            'role' => 'student',
        ]);

        // 5. Create Artworks (Dummy Data)
        // We will create some manual ones for better control, then factory
        
        $artwork1 = Artwork::create([
            'user_id' => 2, // Assuming a researcher
            'category_id' => 2, // Digital Media
            'technique_id' => 4, // 3D Rendering
            'institution_id' => 2,
            'title' => 'Neural Landscapes I',
            'slug' => Str::slug('Neural Landscapes I'),
            'description' => 'An exploration of latent space using Generative Adversarial Networks to hallucinate non-existent landscapes.',
            'year' => 2024,
            'image_path' => 'artworks/demo1.svg', // Placeholder
            'status' => 'published',
            'is_featured' => true,
        ]);

        $artwork2 = Artwork::create([
            'user_id' => 3,
            'category_id' => 6, // Installation
            'technique_id' => 8, // Projection Mapping
            'institution_id' => 1,
            'title' => 'Echoes of Silence',
            'slug' => Str::slug('Echoes of Silence'),
            'description' => 'Interactive sound installation responding to viewer movement.',
            'year' => 2023,
            'image_path' => 'artworks/demo2.svg', // Placeholder
            'status' => 'published',
            'is_featured' => true,
        ]);

        // 6. Create Publications
        Publication::create([
            'user_id' => 2,
            'title' => 'The Aesthetics of Artificial Intelligence',
            'slug' => Str::slug('The Aesthetics of Artificial Intelligence'),
            'published_date' => '2024-05-12',
            'external_link' => 'https://example.com/paper',
            'abstract' => 'A comprehensive study on...'
        ]);
    }
}
