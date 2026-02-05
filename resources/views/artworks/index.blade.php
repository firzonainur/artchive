<x-app-layout>
    <div class="bg-gray-900 min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header & Search -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">Artwork Archive</h1>
                    <p class="text-gray-400 text-sm">Browsing {{ $artworks->total() }} academic works</p>
                </div>
                
                <form action="{{ route('artworks.index') }}" method="GET" class="w-full md:w-1/3">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            class="w-full bg-gray-800 border border-gray-700 text-white rounded-full py-2 px-4 pl-10 focus:ring-purple-500 focus:border-purple-500 placeholder-gray-500"
                            placeholder="Search by title or keyword...">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Filters Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                        <h3 class="text-white font-semibold mb-4 border-b border-gray-700 pb-2">Filters</h3>
                        
                        <!-- Categories -->
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-400 mb-2 uppercase tracking-wider">Category</h4>
                            <div class="space-y-2">
                                <a href="{{ route('artworks.index') }}" class="block text-sm {{ !request('category') ? 'text-purple-400 font-bold' : 'text-gray-300 hover:text-white' }}">
                                    All Categories
                                </a>
                                @foreach($categories as $category)
                                    <a href="{{ route('artworks.index', array_merge(request()->all(), ['category' => $category->id])) }}" 
                                       class="block text-sm {{ request('category') == $category->id ? 'text-purple-400 font-bold' : 'text-gray-300 hover:text-white' }}">
                                        {{ $category->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Institutions (Placeholder for now) -->
                         <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-400 mb-2 uppercase tracking-wider">Institution</h4>
                             <div class="space-y-2 max-h-40 overflow-y-auto custom-scrollbar">
                                @foreach($institutions as $inst)
                                     <label class="flex items-center space-x-2 text-sm text-gray-300 cursor-pointer">
                                        <input type="checkbox" class="rounded border-gray-600 bg-gray-700 text-purple-500 focus:ring-purple-500">
                                        <span>{{ $inst->name }}</span>
                                    </label>
                                @endforeach
                             </div>
                        </div>
                    </div>
                </div>

                <!-- Grid -->
                <div class="lg:col-span-3">
                    @if($artworks->isEmpty())
                        <div class="text-center py-20 bg-gray-800/50 rounded-xl border border-gray-700 border-dashed">
                            <svg class="mx-auto h-12 w-12 text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h3 class="text-lg font-medium text-white">No artworks found</h3>
                            <p class="text-gray-400">Try adjusting your search or filters.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach($artworks as $artwork)
                                <div class="group bg-gray-800 rounded-xl overflow-hidden border border-gray-700 hover:border-purple-500/50 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                                    <a href="{{ route('artworks.show', $artwork->id) }}" class="block relative aspect-w-4 aspect-h-3 bg-gray-700 overflow-hidden">
                                        <img src="{{ Storage::url($artwork->image_path) }}" alt="{{ $artwork->title }}" class="object-cover w-full h-full transform group-hover:scale-105 transition-transform duration-500">
                                        <div class="absolute top-2 right-2">
                                            <span class="px-2 py-1 bg-black/60 backdrop-blur-sm rounded text-xs text-white border border-white/10">
                                                {{ $artwork->category->name }}
                                            </span>
                                        </div>
                                    </a>
                                    <div class="p-4">
                                        <h3 class="text-lg font-bold text-white mb-1 truncate group-hover:text-purple-400 transition-colors">
                                            <a href="{{ route('artworks.show', $artwork->id) }}">{{ $artwork->title }}</a>
                                        </h3>
                                        <div class="flex justify-between items-center text-sm text-gray-400 mt-2">
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                {{ $artwork->user->name }}
                                            </span>
                                        </div>
                                        <div class="mt-3 flex items-center justify-between border-t border-gray-700 pt-3">
                                            <span class="text-xs text-gray-500">{{ $artwork->institution ? $artwork->institution->name : 'Independent' }}</span>
                                            <span class="text-xs text-gray-500">{{ $artwork->year }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-8">
                            {{ $artworks->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
