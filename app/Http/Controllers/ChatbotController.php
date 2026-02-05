<?php

namespace App\Http\Controllers;

use App\Services\GeminiService;
use App\Models\Artwork;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    protected $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        // Check if Chatbot is Enabled
        $isEnabled = \App\Models\Setting::where('key', 'chatbot_enabled')->value('value') === 'true';
        if (!$isEnabled) {
            return response()->json([
                'success' => false,
                'message' => 'Chatbot saat ini dinonaktifkan oleh administrator.'
            ], 403);
        }

        $userMessage = $request->input('message');
        
        try {
            // Build the system context with data from the database
            $context = $this->buildSystemContext();

            $response = $this->geminiService->generateContent($userMessage, $context);

            if ($response && isset($response['candidates'][0]['content']['parts'][0]['text'])) {
                $botReply = $response['candidates'][0]['content']['parts'][0]['text'];
                
                return response()->json([
                    'success' => true,
                    'message' => $botReply
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Maaf, saya sedang mengalami masalah saat menghubungkan ke sistem saat ini.'
            ], 503);

        } catch (\Exception $e) {
            Log::error('Chatbot Controller Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan yang tidak terduga.'
            ], 500);
        }
    }

    public function status()
    {
        $isEnabled = \App\Models\Setting::where('key', 'chatbot_enabled')->value('value') === 'true';
        
        return response()->json([
            'enabled' => $isEnabled
        ]);
    }

    private function buildSystemContext()
    {
        $appName = config('app.name', 'Academic Artworks Archive');
        
        // 1. Fetch Categories
        $categories = Category::all(['name', 'description'])->toArray();

        // 2. Fetch Recent Artworks
        $artworks = Artwork::with(['user:id,name', 'category:id,name', 'technique:id,name'])
            ->where('status', 'published')
            ->latest()
            ->take(30) // Increased limit to cover more "whole website" feel
            ->get()
            ->map(function($a) {
                return [
                    'type' => 'Artwork',
                    'title' => $a->title,
                    'artist' => $a->user ? $a->user->name : 'Unknown',
                    'category' => $a->category ? $a->category->name : 'General',
                    'technique' => $a->technique ? $a->technique->name : 'Mixed',
                    'description' => \Illuminate\Support\Str::limit(strip_tags($a->description), 100),
                    'url' => route('artworks.show', $a->id)
                ];
            })->toArray();

        // 3. Fetch Learning Materials
        $learningMaterials = \App\Models\LearningMaterial::where('is_published', true)
            ->latest()
            ->take(20)
            ->get()
            ->map(function($l) {
                return [
                    'type' => 'Learning Material',
                    'title' => $l->title,
                    'excerpt' => \Illuminate\Support\Str::limit(strip_tags($l->content), 100),
                    'url' => route('learning.show', $l->slug)
                ];
            })->toArray();

        // 4. Fetch Research Publications
        $publications = \App\Models\Publication::latest()
            ->take(20)
            ->get()
            ->map(function($p) {
                return [
                    'type' => 'Research',
                    'title' => $p->title,
                    'author' => $p->user ? $p->user->name : 'Unknown',
                    'abstract' => \Illuminate\Support\Str::limit(strip_tags($p->abstract), 100),
                    'url' => route('research.show', $p->slug) // Assuming route exists, or use external if needed
                ];
            })->toArray();

        // 5. Static Pages
        $staticPages = [
            ['title' => 'Virtual Exhibition', 'description' => 'Experience artworks in an immersive 3D environment.', 'url' => route('virtual.exhibition')],
            ['title' => 'About Us', 'description' => 'Learn more about the Academic Archive project.', 'url' => route('home')], // Fallback to home if no about page
        ];

        $dataContext = [
            'platform_name' => $appName,
            'current_date' => now()->format('D, d M Y'),
            'categories' => $categories,
            'content_inventory' => array_merge($artworks, $learningMaterials, $publications, $staticPages)
        ];

        $jsonContext = json_encode($dataContext, JSON_PRETTY_PRINT);

        return <<<EOT
Anda adalah "Academic AI", asisten virtual cerdas untuk website "{$appName}".
Tugas utama Anda adalah menjadi **Pemandu Kuratorial** dan **Asisten Riset** bagi pengunjung.

BAHAN PENGETAHUAN ANDA (JSON):
{$jsonContext}

INSTRUKSI KHUSUS:
1.  **Gaya Bicara:** Profesional, akademis, namun ramah dan sangat membantu.
2.  **Rekomendasi Konten:**
    *   Jika pengguna bertanya tentang topik tertentu (misal: "Seni Digital" atau "Belajar 3D"), CARI di `content_inventory` Anda.
    *   Berikan rekomendasi spesifik. Jangan hanya bilang "banyak karya", tapi sebutkan judulnya.
    *   **WAJIB SERTAKAN LINK:** Setiap kali menyebutkan judul Proyek, Artikel Belajar, atau Riset, formatlah menjadi markdown link: `[Judul Item](URL)`.
3.  **Cross-Promotion:**
    *   Jika pengguna melihat Karya Seni, sarankan juga Artikel Belajar atau Riset yang relevan jika ada.
    *   Promosikan fitur "Virtual Exhibition" untuk pengalaman imersif.
4.  **Bahasa:** Gunakan Bahasa Indonesia yang baik dan benar.
5.  **Konteks Website:** Anda tahu seluruh isi website berdasarkan data JSON di atas. Jika data tidak ada, katakan dengan jujur bahwa Anda tidak menemukan data spesifik di arsip saat ini, namun pengguna bisa mengeksplorasi menu terkait.

CONTOH RESPON:
"Untuk topik tersebut, saya sangat merekomendasikan Anda membaca artikel pembelajaran [Dasar-Dasar Fotografi](url). Selain itu, Anda bisa melihat penerapan teknik tersebut pada karya [Urban Solitude](url) oleh Budi Santoso."
EOT;
    }
}
