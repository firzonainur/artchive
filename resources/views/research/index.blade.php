<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-100 leading-tight">
                {{ __('Academic Research') }}
            </h2>
            @auth
                <a href="{{ route('research.create') }}" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-cyan-500 rounded-lg text-sm font-bold text-white shadow-lg hover:shadow-purple-500/30 transition">
                    + Publish Paper
                </a>
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search & Filter -->
            <div class="mb-8 bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-lg">
                <form method="GET" action="{{ route('research.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-3">
                        <x-text-input 
                            name="search" 
                            type="text" 
                            value="{{ request('search') }}" 
                            placeholder="Search research papers..." 
                            class="w-full"
                        />
                    </div>
                    <div>
                        <select name="sort" onchange="this.form.submit()" class="w-full py-3 px-4 bg-gray-800 border border-gray-600 text-white rounded-lg shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500/50 transition-all duration-200 cursor-pointer">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        </select>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($publications as $pub)
                <a href="{{ route('research.show', $pub->slug) }}" class="group">
                    <div class="h-full bg-gray-800 border border-gray-700 rounded-xl p-6 hover:border-purple-500 hover:shadow-lg hover:shadow-purple-500/10 transition-all duration-300 flex flex-col">
                        <div class="text-xs font-bold text-cyan-400 mb-2 uppercase tracking-wider">
                            {{ $pub->published_date ? $pub->published_date->format('M Y') : 'Draft' }}
                        </div>
                        
                        <h3 class="text-xl font-bold text-white mb-3 group-hover:text-purple-400 transition-colors line-clamp-2">
                            {{ $pub->title }}
                        </h3>

                        <p class="text-gray-400 text-sm mb-6 line-clamp-3 flex-grow">
                            {{ $pub->abstract }}
                        </p>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-700">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center text-xs font-bold text-white mr-3">
                                    {{ substr($pub->user->name, 0, 1) }}
                                </div>
                                <span class="text-xs text-gray-400">{{ $pub->user->name }}</span>
                            </div>
                            <span class="text-purple-400 text-sm font-medium group-hover:translate-x-1 transition-transform">Read &rarr;</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $publications->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
