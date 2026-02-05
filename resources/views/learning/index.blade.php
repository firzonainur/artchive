<x-app-layout>
    <div class="py-12 bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-extrabold text-white mb-4">Pusat Belajar</h1>
                <p class="text-lg text-gray-400">Jelajahi materi pembelajaran, tutorial, dan referensi seni akademik.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($materials as $material)
                    <div class="bg-gray-800 rounded-2xl overflow-hidden border border-gray-700 hover:border-purple-500/50 transition-all hover:-translate-y-1 shadow-lg group">
                        
                        <!-- Image Cover -->
                        <div class="h-48 bg-gray-700 relative overflow-hidden">
                            @if($material->image_path)
                                <img src="{{ Storage::url($material->image_path) }}" alt="{{ $material->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-800 to-gray-700">
                                    <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="p-6">
                            <h2 class="text-xl font-bold text-white mb-3 line-clamp-2 group-hover:text-purple-400 transition-colors">
                                <a href="{{ route('learning.show', $material->slug) }}">{{ $material->title }}</a>
                            </h2>
                            <p class="text-gray-400 mb-6 line-clamp-3 text-sm">
                                {{ Str::limit(strip_tags($material->content), 120) }}
                            </p>
                            <div class="flex items-center justify-between mt-auto">
                                <a href="{{ route('learning.show', $material->slug) }}" class="inline-flex items-center text-sm font-medium text-purple-400 hover:text-purple-300 transition-colors">
                                    Baca Selengkapnya
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                                <span class="text-xs text-gray-500">{{ $material->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-300">Belum ada materi pembelajaran.</h3>
                        <p class="text-gray-500">Silakan kembali lagi nanti.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $materials->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
