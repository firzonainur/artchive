<x-admin-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-700">
                <div class="p-6 border-b border-gray-700 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-white">Add New Learning Material</h2>
                    <a href="{{ route('admin.learning.index') }}" class="text-gray-400 hover:text-white transition">Cancel</a>
                </div>

                <div class="p-8">
                    <form action="{{ route('admin.learning.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf

                        <!-- Title -->
                        <div>
                            <x-input-label for="title" value="Title *" class="text-lg mb-2" />
                            <x-text-input id="title" name="title" type="text" class="block w-full text-lg" :value="old('title')" placeholder="Enter material title..." required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <!-- Content -->
                        <div>
                            <x-input-label for="content" value="Content / Description *" class="mb-2" />
                            <textarea name="content" id="content" rows="10"
                                class="w-full py-3 px-4 bg-gray-900 border border-gray-700 text-white rounded-lg shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500/50 transition-all duration-200 placeholder-gray-500"
                                placeholder="Write the content here..." required>{{ old('content') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('content')" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Image -->
                            <div>
                                <x-input-label for="image" value="Cover Image" class="mb-2" />
                                <div class="relative group">
                                    <x-file-input id="image" name="image" accept="image/*" class="w-full" />
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Recommended size: 800x600px (Max 2MB)</p>
                                <x-input-error class="mt-2" :messages="$errors->get('image')" />
                            </div>

                            <!-- File -->
                            <div>
                                <x-input-label for="file" value="Attachment (PDF/Doc)" class="mb-2" />
                                <x-file-input id="file" name="file" accept=".pdf,.doc,.docx" class="w-full" />
                                <p class="mt-1 text-sm text-gray-500">Optional resource file (Max 10MB)</p>
                                <x-input-error class="mt-2" :messages="$errors->get('file')" />
                            </div>
                        </div>

                        <!-- Published -->
                        <div class="flex items-center space-x-3 bg-gray-900/50 p-4 rounded-lg border border-gray-700">
                             <input type="checkbox" name="is_published" id="is_published" value="1" class="rounded bg-gray-800 border-gray-600 text-purple-600 shadow-sm focus:ring-purple-500 w-5 h-5 transition-colors" {{ old('is_published', true) ? 'checked' : '' }}>
                             <label for="is_published" class="text-sm text-gray-300 font-medium cursor-pointer select-none">
                                Publish Immediately
                                <span class="block text-xs text-gray-500 font-normal">If unchecked, this will be saved as a draft.</span>
                             </label>
                        </div>

                        <div class="flex items-center justify-end pt-6 border-t border-gray-700 gap-3">
                            <x-secondary-button type="button" onclick="window.location='{{ route('admin.learning.index') }}'">
                                Cancel
                            </x-secondary-button>
                            <x-primary-button>
                                Create Material
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
