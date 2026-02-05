<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Research Detail') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
             <div class="bg-gray-800 border border-gray-700 rounded-xl overflow-hidden shadow-2xl">
                <div class="p-8 md:p-12">
                     <div class="flex items-center space-x-4 mb-6">
                        <span class="px-3 py-1 bg-purple-900/50 text-purple-300 rounded-full text-xs font-bold uppercase tracking-wider">
                            Academic Paper
                        </span>
                        <span class="text-gray-400 text-sm">
                             {{ $publication->published_date ? $publication->published_date->format('F d, Y') : 'Unpublished' }}
                        </span>
                    </div>

                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-6 leading-tight">
                        {{ $publication->title }}
                    </h1>

                    <div class="flex items-center mb-8 border-b border-gray-700 pb-8">
                         <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-cyan-500 flex items-center justify-center text-white font-bold text-lg mr-4">
                            {{ substr($publication->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-white font-medium">{{ $publication->user->name }}</p>
                            <p class="text-gray-500 text-xs">Researcher / Contributor</p>
                        </div>
                    </div>

                    <div class="prose prose-invert max-w-none text-gray-300 mb-10">
                        <h3 class="text-xl font-bold text-white mb-4">Abstract</h3>
                        <p class="leading-relaxed">
                            {{ $publication->abstract }}
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-wrap gap-4 mb-12">
                        @if($publication->file_path)
                            <a href="{{ Storage::url($publication->file_path) }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white font-bold rounded-lg transition border border-gray-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Download PDF
                            </a>
                        @endif

                        @if($publication->external_link)
                            <a href="{{ $publication->external_link }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-transparent hover:bg-gray-700 text-cyan-400 font-bold rounded-lg transition border border-cyan-500/30">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                View External Source
                            </a>
                        @endif
                    </div>

                    <!-- Referenced Artworks -->
                    @if($publication->artworks->count() > 0)
                    <div class="border-t border-gray-700 pt-8">
                        <h3 class="text-lg font-bold text-white mb-4">Referenced Artworks in Archive</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($publication->artworks as $artwork)
                            <a href="{{ route('artworks.show', $artwork->id) }}" class="flex items-center p-3 bg-gray-900 rounded-lg hover:bg-gray-700 transition group">
                                <div class="w-12 h-12 bg-gray-800 rounded bg-cover bg-center" style="background-image: url('{{ Storage::url($artwork->image_path) }}')"></div>
                                <div class="ml-4">
                                    <p class="text-white font-medium group-hover:text-purple-400 transition">{{ $artwork->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $artwork->year }}</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
             </div>
        </div>
    </div>
</x-app-layout>
