<x-app-layout>
    <div class="py-12 bg-gray-950 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('learning.index') }}" class="inline-flex items-center text-gray-400 hover:text-white mb-8 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Pusat Belajar
            </a>

            <article class="bg-gray-900 rounded-2xl overflow-hidden border border-gray-800 shadow-xl">
                @if($material->image_path)
                    <div class="w-full h-80 relative">
                        <img src="{{ Storage::url($material->image_path) }}" alt="{{ $material->title }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent"></div>
                    </div>
                @endif

                <div class="p-8 sm:p-12">
                    <header class="mb-8">
                        <h1 class="text-3xl sm:text-4xl font-extrabold text-white mb-4 leading-tight">{{ $material->title }}</h1>
                        <div class="flex items-center text-gray-400 text-sm">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $material->created_at->format('d F Y') }}
                            </span>
                        </div>
                    </header>

                    <div class="prose prose-invert prose-lg max-w-none text-gray-300">
                        {!! nl2br(e($material->content)) !!}
                    </div>

                    @if($material->file_path)
                        <div class="mt-12 pt-8 border-t border-gray-800">
                            <h3 class="text-lg font-bold text-white mb-4">Lampiran</h3>
                            <a href="{{ Storage::url($material->file_path) }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-medium transition-colors shadow-lg shadow-purple-900/30">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Unduh Materi
                            </a>
                        </div>
                    @endif
                </div>
            </article>
        </div>
    </div>
</x-app-layout>
