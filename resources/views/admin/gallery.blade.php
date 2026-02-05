<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Visual Gallery') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($artworks as $artwork)
                    <div class="relative group aspect-square bg-gray-800 rounded-lg overflow-hidden border border-gray-700">
                        <!-- Image -->
                        <img src="{{ Storage::url($artwork->image_path) }}" 
                             alt="{{ $artwork->title }}" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        
                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="absolute bottom-0 left-0 right-0 p-4">
                                <h3 class="text-white font-bold text-sm truncate">{{ $artwork->title }}</h3>
                                <p class="text-gray-400 text-xs">{{ $artwork->user->name ?? 'Unknown' }}</p>
                                <a href="{{ route('artworks.show', $artwork->id) }}" class="mt-2 text-cyan-400 text-xs hover:text-cyan-300 block">
                                    View Details &rarr;
                                </a>
                            </div>
                        </div>

                        <!-- Status Badge -->
                        <div class="absolute top-2 right-2">
                             <span class="px-2 py-1 text-xs font-bold rounded-full {{ $artwork->status === 'published' ? 'bg-green-500/80 text-white' : 'bg-yellow-500/80 text-white' }}">
                                {{ ucfirst($artwork->status) }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $artworks->links() }}
            </div>
            
        </div>
    </div>
</x-admin-layout>
