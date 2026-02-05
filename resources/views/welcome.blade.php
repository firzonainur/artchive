<x-app-layout>
    <!-- Hero Section -->
    <!-- Hero Slider Section -->
    <div class="relative bg-gray-900 overflow-hidden h-[600px]" x-data="{ 
        activeSlide: 0, 
        slides: {{ $featuredArtworks->isNotEmpty() ? $featuredArtworks->map(fn($a) => [
            'image' => Storage::url($a->image_path),
            'title' => $a->title,
            'description' => Str::limit($a->description, 100),
            'link' => route('artworks.show', $a->id)
        ]) : json_encode([[
            'image' => 'https://images.unsplash.com/photo-1549490349-8643362247b5?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80',
            'title' => 'Temukan Karya Seni Akademik Otentik',
            'description' => 'Pusat pelestarian dan penelitian digital utama untuk kreasi mahasiswa dan dosen.',
            'link' => route('artworks.index')
        ], [
             'image' => 'https://images.unsplash.com/photo-1554907984-15263bfd63bd?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80',
             'title' => 'Keunggulan Terkurasi',
             'description' => 'Jelajahi karya terbaik dari institusi terkemuka dan bakat baru.',
             'link' => route('artworks.index')
        ]]) }}
    }" x-init="setInterval(() => { activeSlide = activeSlide === slides.length - 1 ? 0 : activeSlide + 1 }, 6000)">
        
        <!-- Slides -->
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="activeSlide === index"
                 x-transition:enter="transition transform duration-1000 ease-out"
                 x-transition:enter-start="opacity-0 scale-105"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition transform duration-1000 ease-in"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute inset-0 w-full h-full">
                
                <!-- Background Image -->
                <img :src="slide.image" class="w-full h-full object-cover">
                
                <!-- Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-gray-900/80 via-transparent to-transparent"></div>

                <!-- Content -->
                <div class="absolute inset-0 flex items-center">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                        <div class="max-w-xl space-y-6">
                            <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight leading-tight" x-text="slide.title"></h1>
                            <p class="text-lg text-gray-300 md:text-xl" x-text="slide.description"></p>
                            <div>
                                <div class="flex flex-wrap gap-4">
                                    <a :href="slide.link" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-full text-white bg-purple-600 hover:bg-purple-700 md:py-4 md:text-lg transition shadow-lg shadow-purple-900/50">
                                        Lihat Karya
                                    </a>
                                    
                                    @auth
                                        <a href="{{ route('artworks.create') }}" class="inline-flex items-center justify-center px-8 py-3 border border-gray-400 text-base font-medium rounded-full text-white bg-black/30 hover:bg-black/50 backdrop-blur-sm md:py-4 md:text-lg transition hover:border-white">
                                            Kirim Karya
                                        </a>
                                    @else
                                        <div class="flex gap-4">
                                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-3 border border-gray-400 text-base font-medium rounded-full text-white bg-black/30 hover:bg-black/50 backdrop-blur-sm md:py-4 md:text-lg transition hover:border-white">
                                                Gabung Sekarang
                                            </a>
                                        </div>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!-- Navigation Arrows -->
        <button @click="activeSlide = activeSlide === 0 ? slides.length - 1 : activeSlide - 1" class="absolute left-4 top-1/2 -translate-y-1/2 p-3 rounded-full bg-black/30 text-white hover:bg-black/50 backdrop-blur-sm transition focus:outline-none">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <button @click="activeSlide = activeSlide === slides.length - 1 ? 0 : activeSlide + 1" class="absolute right-4 top-1/2 -translate-y-1/2 p-3 rounded-full bg-black/30 text-white hover:bg-black/50 backdrop-blur-sm transition focus:outline-none">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>

        <!-- Indicators -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-3">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="activeSlide = index" 
                        class="w-3 h-3 rounded-full transition-all duration-300"
                        :class="activeSlide === index ? 'bg-white w-8' : 'bg-gray-500 hover:bg-gray-400'"></button>
            </template>
        </div>
    </div>

    <!-- Featured Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-3xl font-bold text-white mb-2">Karya Unggulan</h2>
                <p class="text-gray-400">Pilihan terkurasi dari institusi terbaik</p>
            </div>
            <a href="{{ route('artworks.index') }}" class="text-purple-400 hover:text-purple-300 font-medium flex items-center gap-1 transition-colors">
                Lihat Semua <span class="text-xl">&rarr;</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($featuredArtworks as $artwork)
                <div class="group relative bg-gray-800 rounded-2xl overflow-hidden border border-gray-700 card-hover">
                    <div class="aspect-w-4 aspect-h-3 bg-gray-700 overflow-hidden relative">
                        <img src="{{ Storage::url($artwork->image_path) }}" alt="{{ $artwork->title }}" class="object-cover w-full h-full transform group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-60"></div>
                        <div class="absolute top-4 right-4">
                            <span class="px-3 py-1 bg-black/50 backdrop-blur-md rounded-full text-xs font-semibold text-white border border-white/10">
                                {{ $artwork->category->name }}
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-white mb-1 group-hover:text-purple-400 transition-colors truncate">
                            {{ $artwork->title }}
                        </h3>
                        <div class="flex justify-between items-center text-sm text-gray-400">
                            <span class="flex items-center gap-2">
                                <div class="w-5 h-5 rounded-full bg-gray-600"></div>
                                {{ $artwork->user->name }}
                            </span>
                            <span>{{ $artwork->year }}</span>
                        </div>
                    </div>
                    <a href="{{ route('artworks.show', $artwork->id) }}" class="absolute inset-0 z-10"></a>
                </div>
            @empty
                <!-- Demo Placeholders -->
                @for($i = 0; $i < 3; $i++)
                <div class="group relative bg-gray-800 rounded-2xl overflow-hidden border border-gray-700 card-hover">
                    <div class="aspect-w-4 aspect-h-3 bg-gray-700 relative overflow-hidden">
                        <div class="absolute inset-0 flex items-center justify-center text-gray-600 bg-gray-800">
                            <span class="text-4xl text-gray-700/50 font-bold">SENI</span>
                        </div>
                        <div class="absolute top-4 right-4">
                             <span class="px-3 py-1 bg-black/50 backdrop-blur-md rounded-full text-xs font-semibold text-white border border-white/10">
                                Seni Digital
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-white mb-1">Neo-Abstrak #{{ $i+1 }}</h3>
                        <div class="flex justify-between items-center text-sm text-gray-400">
                            <span>Artis Demo</span>
                            <span>2024</span>
                        </div>
                    </div>
                </div>
                @endfor
            @endforelse
        </div>
    </div>

    <!-- Categories Marquee or Grid -->
    <div class="bg-gray-800/30 py-16 border-y border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-center text-white mb-12">Jelajahi Berdasarkan Kategori</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($categories as $category)
                    <a href="{{ route('artworks.index', ['category' => $category->id]) }}" class="group flex flex-col items-center p-6 bg-gray-900 rounded-xl border border-gray-800 hover:border-purple-500/50 hover:bg-gray-800 transition-all">
                        <div class="w-16 h-16 mb-4 rounded-xl overflow-hidden shadow-lg group-hover:scale-110 group-hover:shadow-purple-500/30 transition-all duration-300">
                            @if($category->icon)
                                <img src="{{ Storage::url($category->icon) }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-800 flex items-center justify-center text-purple-400 border border-gray-700">
                                    <span class="text-2xl font-bold">{{ substr($category->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <span class="text-gray-300 font-medium group-hover:text-white text-center">{{ $category->name }}</span>
                    </a>
                @endforeach
                 <!-- Static Demo Categories if empty -->
                 @if($categories->isEmpty())
                     @foreach(['Fotografi', 'Patung', 'Lukisan', 'Digital', 'Media Campuran', 'Instalasi'] as $cat)
                     <div class="group flex flex-col items-center p-6 bg-gray-900 rounded-xl border border-gray-800 hover:border-purple-500/50 hover:bg-gray-800 transition-all cursor-pointer">
                        <div class="w-12 h-12 mb-3 rounded-lg bg-gray-800 flex items-center justify-center text-xl group-hover:scale-110 transition-transform text-purple-400 border border-gray-700">
                           ★
                        </div>
                        <span class="text-gray-300 font-medium group-hover:text-white">{{ $cat }}</span>
                    </div>
                     @endforeach
                 @endif
            </div>
        </div>
    </div>
</x-app-layout>
