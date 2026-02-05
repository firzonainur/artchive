<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Manage Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-6">
                <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-cyan-500 rounded-lg text-sm font-bold text-white shadow-lg hover:shadow-purple-500/30 transition">
                    + Add Category
                </a>
            </div>

            <div class="bg-gray-800 border border-gray-700 rounded-xl overflow-hidden shadow-xl">
                <table class="w-full text-left text-gray-300">
                    <thead class="bg-gray-700 text-gray-100 uppercase text-xs font-bold">
                        <tr>
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Icon</th>
                            <th class="px-6 py-4">Name</th>
                            <th class="px-6 py-4">Slug</th>
                            <th class="px-6 py-4">Artworks Count</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @foreach ($categories as $category)
                        <tr class="hover:bg-gray-750 transition">
                            <td class="px-6 py-4">{{ $category->id }}</td>
                            <td class="px-6 py-4">
                                @if($category->icon)
                                    <img src="{{ Storage::url($category->icon) }}" alt="Icon" class="w-10 h-10 rounded object-cover border border-gray-600">
                                @else
                                    <div class="w-10 h-10 rounded bg-gray-700 flex items-center justify-center text-xs text-gray-500">N/A</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-white">{{ $category->name }}</td>
                            <td class="px-6 py-4 text-gray-400">{{ $category->slug }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-gray-900 rounded text-xs text-gray-300">{{ $category->artworks_count }}</span>
                            </td>
                            <td class="px-6 py-4 text-right flex justify-end space-x-3">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-cyan-400 hover:text-cyan-300">Edit</a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
