<x-app-layout>
    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gray-800/80 backdrop-blur-sm overflow-hidden shadow-lg rounded-xl border border-gray-700 p-6 flex flex-col justify-center">
                    <div class="text-gray-400 text-sm uppercase font-semibold tracking-wider">My Artworks</div>
                    <div class="text-4xl font-bold text-white mt-2">{{ $artworks->total() }}</div>
                </div>
                <div class="bg-gray-800/80 backdrop-blur-sm overflow-hidden shadow-lg rounded-xl border border-gray-700 p-6 flex flex-col justify-center">
                    <div class="text-gray-400 text-sm uppercase font-semibold tracking-wider">Favorites</div>
                    <div class="text-4xl font-bold text-white mt-2">{{ $favorites->count() }}</div>
                </div>
                <div class="bg-gray-800/80 backdrop-blur-sm overflow-hidden shadow-lg rounded-xl border border-gray-700 p-6 flex flex-col justify-center">
                    <div class="text-gray-400 text-sm uppercase font-semibold tracking-wider">Account Status</div>
                    <div class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-cyan-400 mt-2 capitalize">{{ $user->role }}</div>
                </div>
            </div>

            <div class="bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-700">
                <div class="p-6 border-b border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-white">Manage My Artworks</h3>
                    <a href="{{ route('artworks.create') }}" class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium transition shadow-lg shadow-purple-900/40">
                        + Upload New Artwork
                    </a>
                </div>
                <div class="p-6">
                    @if($artworks->isEmpty())
                        <div class="text-center py-8 text-gray-500">
                            You haven't uploaded any artworks yet.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-700">
                                <thead class="bg-gray-900/50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Artwork</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Uploaded</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-700">
                                    @foreach($artworks as $artwork)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-10 w-10 flex-shrink-0">
                                                        <img class="h-10 w-10 rounded-md object-cover" src="{{ Storage::url($artwork->image_path) }}" alt="">
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-white">{{ $artwork->title }}</div>
                                                        <div class="text-sm text-gray-400">{{ $artwork->category->name }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 w-24 justify-center inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $artwork->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ ucfirst($artwork->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                                {{ $artwork->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('artworks.show', $artwork->id) }}" class="text-indigo-400 hover:text-indigo-300 mr-3">View</a>
                                                <a href="{{ route('artworks.edit', $artwork->id) }}" class="text-gray-400 hover:text-white">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $artworks->links() }}
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Favorites Section -->
             <div class="mt-8 bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-700">
                <div class="p-6 border-b border-gray-700">
                    <h3 class="text-lg font-medium text-white">Recent Favorites</h3>
                </div>
                <div class="p-6">
                    @if($favorites->isEmpty())
                        <p class="text-gray-500">No favorites yet.</p>
                    @else
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                            @foreach($favorites as $fav)
                                <a href="{{ route('artworks.show', $fav->id) }}" class="block group relative aspect-w-1 aspect-h-1 bg-gray-700 rounded-lg overflow-hidden">
                                     <img src="{{ Storage::url($fav->image_path) }}" class="object-cover w-full h-full opacity-80 group-hover:opacity-100 transition">
                                     <div class="absolute bottom-0 left-0 right-0 p-2 bg-gradient-to-t from-black/80 to-transparent">
                                         <p class="text-xs text-white truncate">{{ $fav->title }}</p>
                                     </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
