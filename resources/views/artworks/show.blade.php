<x-app-layout>
    <div class="bg-gray-900 min-h-screen py-10" x-data="{ activeTab: 'details' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <nav class="flex mb-8 text-sm text-gray-400">
                <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('artworks.index') }}" class="hover:text-white">Archive</a>
                <span class="mx-2">/</span>
                <span class="text-purple-400 truncate max-w-xs">{{ $artwork->title }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <!-- Main Visual Column -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-gray-800 rounded-2xl overflow-hidden border border-gray-700 shadow-2xl relative group">
                        <img src="{{ Storage::url($artwork->image_path) }}" alt="{{ $artwork->title }}" class="w-full h-auto object-contain max-h-[80vh] bg-black">
                        
                        <!-- Overlay Actions (Zoom, etc.) -->
                        <div class="absolute bottom-4 right-4 flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                             <button class="p-2 bg-black/60 backdrop-blur-md rounded-full text-white hover:bg-purple-600 transition">
                                 <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                 </svg>
                             </button>
                        </div>
                    </div>

                    <!-- Additional Views (Gallery) -->
                    @if(!empty($artwork->gallery_images))
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($artwork->gallery_images as $image)
                            <div class="aspect-w-1 aspect-h-1 bg-gray-800 rounded-lg overflow-hidden border border-gray-700 cursor-pointer hover:border-purple-500 transition">
                                <img src="{{ Storage::url($image) }}" class="object-cover w-full h-full">
                            </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- Tabs Section -->
                    <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden">
                        <div class="flex border-b border-gray-700">
                            <button @click="activeTab = 'details'" :class="{ 'bg-gray-700 text-white border-b-2 border-purple-500': activeTab === 'details', 'text-gray-400 hover:text-white': activeTab !== 'details' }" class="px-6 py-4 font-medium transition flex-1 text-center">
                                Description & Context
                            </button>
                            <button @click="activeTab = 'publications'" :class="{ 'bg-gray-700 text-white border-b-2 border-purple-500': activeTab === 'publications', 'text-gray-400 hover:text-white': activeTab !== 'publications' }" class="px-6 py-4 font-medium transition flex-1 text-center">
                                Cited In ({{ $artwork->publications->count() }})
                            </button>
                            <button @click="activeTab = 'comments'" :class="{ 'bg-gray-700 text-white border-b-2 border-purple-500': activeTab === 'comments', 'text-gray-400 hover:text-white': activeTab !== 'comments' }" class="px-6 py-4 font-medium transition flex-1 text-center">
                                Discussion
                            </button>
                        </div>
                        <div class="p-6 min-h-[200px]">
                            <!-- Details Tab -->
                            <div x-show="activeTab === 'details'" class="space-y-4 text-gray-300 leading-relaxed">
                                <h3 class="text-lg font-bold text-white mb-2">About the Artwork</h3>
                                <p>{{ $artwork->description ?: 'No description provided.' }}</p>
                                
                                <div class="grid grid-cols-2 gap-4 mt-6">
                                    <div class="bg-gray-900 p-4 rounded-lg">
                                        <span class="block text-xs text-gray-500 uppercase">Dimensions</span>
                                        <span class="text-white">{{ $artwork->dimensions ?: 'Not specified' }}</span>
                                    </div>
                                    <div class="bg-gray-900 p-4 rounded-lg">
                                        <span class="block text-xs text-gray-500 uppercase">Technique</span>
                                        <span class="text-white">{{ $artwork->technique->name ?? 'Mixed Media' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Publications Tab -->
                            <div x-show="activeTab === 'publications'" x-cloak>
                                @forelse($artwork->publications as $pub)
                                    <div class="mb-4 pb-4 border-b border-gray-700 last:border-0 last:pb-0">
                                        <h4 class="text-white font-bold">{{ $pub->title }}</h4>
                                        <p class="text-sm text-gray-400 mt-1">{{ Str::limit($pub->abstract, 150) }}</p>
                                        <a href="#" class="text-cyan-400 text-sm hover:underline mt-2 inline-block">Read Paper &rarr;</a>
                                    </div>
                                @empty
                                    <p class="text-gray-500 italic">No associated publications yet.</p>
                                @endforelse
                            </div>

                            <!-- Comments Tab -->
                            <div x-show="activeTab === 'comments'" x-cloak>
                                <!-- Comment Form -->
                                @auth
                                    <form action="{{ route('artworks.comments.store', $artwork->id) }}" method="POST" class="mb-8">
                                        @csrf
                                        <div class="mb-4">
                                            <textarea name="body" rows="3" class="w-full bg-gray-900 border border-gray-700 rounded-lg text-white p-4 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition shadow-inner" placeholder="Join the discussion..."></textarea>
                                        </div>
                                        <div class="flex justify-end">
                                            <button type="submit" class="bg-purple-600 hover:bg-purple-500 text-white px-6 py-2 rounded-lg font-bold text-sm transition shadow-lg shadow-purple-900/40">
                                                Post Comment
                                            </button>
                                        </div>
                                    </form>
                                @else
                                    <div class="bg-gray-900 rounded-lg p-6 text-center border border-gray-700 mb-8 max-w-lg mx-auto">
                                        <p class="text-gray-400 mb-4">Please log in to join the discussion.</p>
                                        <a href="{{ route('login') }}" class="inline-block bg-gray-700 hover:bg-white hover:text-gray-900 text-white px-6 py-2 rounded-lg font-bold text-sm transition">Log In</a>
                                    </div>
                                @endauth

                                <!-- Comments List -->
                                <div class="space-y-6">
                                    @forelse($artwork->comments as $comment)
                                        <div class="flex space-x-4 animate-fade-in-up">
                                            <div class="flex-shrink-0">
                                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-700 to-gray-600 flex items-center justify-center text-white font-bold text-sm">
                                                    {{ substr($comment->user->name, 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="flex-grow">
                                                <div class="bg-gray-900 rounded-lg p-4 border border-gray-700 relative">
                                                    <div class="flex justify-between items-center mb-2">
                                                        <h5 class="text-white font-bold text-sm">{{ $comment->user->name }}</h5>
                                                        <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <p class="text-gray-300 text-sm leading-relaxed">{{ $comment->body }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-10">
                                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-800 text-gray-600 mb-3">
                                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                </svg>
                                            </div>
                                            <p class="text-gray-500">No comments yet. Be the first to start the conversation!</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Info -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Artist Profile -->
                    <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="w-14 h-14 rounded-full bg-gradient-to-tr from-purple-500 to-cyan-500 flex items-center justify-center text-xl font-bold text-white ring-2 ring-gray-900">
                                {{ substr($artwork->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-white">{{ $artwork->user->name }}</h3>
                                <p class="text-sm text-purple-400">{{ $artwork->user->role ?? 'Artist' }}</p>
                            </div>
                        </div>
                        
                        <div class="space-y-3 text-sm border-t border-gray-700 pt-4">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Institution</span>
                                <span class="text-gray-200 text-right">{{ $artwork->institution->name ?? $artwork->user->institution ?? 'Independent' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Published</span>
                                <span class="text-gray-200">{{ $artwork->created_at->format('M d, Y') }}</span>
                            </div>
                             <div class="flex justify-between">
                                <span class="text-gray-400">Views</span>
                                <span class="text-gray-200">124</span> <!-- Placeholder -->
                            </div>
                        </div>

                        <div class="mt-6 flex space-x-3">
                            <button class="flex-1 bg-purple-600 hover:bg-purple-500 text-white py-2 rounded-lg font-medium transition shadow-lg shadow-purple-900/40">
                                Follow
                            </button>
                            <button class="flex-1 border border-gray-600 hover:border-white text-gray-300 hover:text-white py-2 rounded-lg font-medium transition">
                                Contact
                            </button>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                        <h3 class="text-white font-semibold mb-4">Actions</h3>
                        <div class="space-y-3">
                            <button class="w-full flex items-center justify-center space-x-2 bg-gray-700 hover:bg-gray-600 text-white py-2 rounded-lg transition">
                                <svg class="w-5 h-5 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <span>Add to Favorites</span>
                            </button>
                            <button class="w-full flex items-center justify-center space-x-2 bg-gray-700 hover:bg-gray-600 text-white py-2 rounded-lg transition">
                                <svg class="w-5 h-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                </svg>
                                <span>Share Artwork</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
