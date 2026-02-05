<x-admin-layout>
    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-white">Manage Artworks</h2>
                <a href="{{ route('admin.index') }}" class="text-gray-400 hover:text-white">&larr; Back to Dashboard</a>
            </div>

            <div class="bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-700">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead class="bg-gray-900/50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Artwork</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Artist</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
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
                                                    <div class="text-xs text-gray-500">{{ $artwork->created_at->format('d M Y') }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                            {{ $artwork->user->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                             <span class="px-2 w-24 justify-center inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $artwork->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ ucfirst($artwork->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                            {{ $artwork->category->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                            <a href="{{ route('artworks.show', $artwork->id) }}" class="text-indigo-400 hover:text-indigo-300">View</a>
                                            
                                            <!-- Approve Button (only if not published) -->
                                            @if($artwork->status !== 'published')
                                                <form action="{{ route('admin.artworks.approve', $artwork->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-green-400 hover:text-green-300">Approve</button>
                                                </form>
                                            @endif

                                            <!-- Delete Button -->
                                            <form action="{{ route('admin.artworks.destroy', $artwork->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-300">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $artworks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
