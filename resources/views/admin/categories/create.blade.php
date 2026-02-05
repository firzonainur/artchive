<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Add New Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 p-8 rounded-xl border border-gray-700 shadow-xl">
                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" value="Category Name *" class="mb-2" />
                        <x-text-input id="name" name="name" type="text" class="block w-full" placeholder="e.g., Abstract Expressionism" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <!-- Icon -->
                    <div>
                        <x-input-label for="icon" value="Category Icon" class="mb-2" />
                        <x-file-input id="icon" name="icon" accept="image/*" class="w-full" />
                        <p class="mt-1 text-xs text-gray-500">Optional. Upload an icon/image to represent this category.</p>
                        <x-input-error class="mt-2" :messages="$errors->get('icon')" />
                    </div>

                    <!-- Description -->
                     <div>
                        <x-input-label for="description" value="Description" class="mb-2" />
                        <textarea name="description" id="description" rows="4"
                            class="w-full py-3 px-4 bg-gray-800 border border-gray-600 text-white rounded-lg shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500/50 transition-all duration-200 placeholder-gray-500"
                            placeholder="Brief description of the category (optional)..."></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-700">
                        <x-secondary-button type="button" onclick="window.history.back()" class="mr-3">
                            Cancel
                        </x-secondary-button>
                        <x-primary-button>
                            Create Category
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
