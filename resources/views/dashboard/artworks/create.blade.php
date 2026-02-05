<x-app-layout>
    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-700">
                <div class="p-6 border-b border-gray-700 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-white">Upload New Artwork</h2>
                    <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white transition">Cancel</a>
                </div>
                
                <div class="p-8">
                    <form action="{{ route('artworks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        
                        <!-- Title -->
                        <div>
                            <x-input-label for="title" value="Artwork Title *" class="text-lg mb-2" />
                            <x-text-input id="title" name="title" type="text" class="block w-full text-lg" placeholder="e.g., Abstract Harmony No. 5" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Category -->
                            <div>
                                <x-input-label for="category_id" value="Category *" class="mb-2" />
                                <x-select-input id="category_id" name="category_id" class="block w-full" required>
                                    <option value="">Select Category...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </x-select-input>
                                <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                            </div>

                             <!-- Technique -->
                            <div>
                                <x-input-label for="technique_id" value="Technique/Medium" class="mb-2" />
                                <x-select-input id="technique_id" name="technique_id" class="block w-full">
                                    <option value="">Select Technique...</option>
                                    @foreach($techniques as $technique)
                                        <option value="{{ $technique->id }}">{{ $technique->name }}</option>
                                    @endforeach
                                </x-select-input>
                                <x-input-error class="mt-2" :messages="$errors->get('technique_id')" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                             <!-- Institution (Optional) -->
                            <div>
                                <x-input-label for="institution_id" value="Associated Institution" class="mb-2" />
                                <x-select-input id="institution_id" name="institution_id" class="block w-full">
                                    <option value="">None / Independent</option>
                                    @foreach($institutions as $inst)
                                        <option value="{{ $inst->id }}">{{ $inst->name }}</option>
                                    @endforeach
                                </x-select-input>
                                <x-input-error class="mt-2" :messages="$errors->get('institution_id')" />
                            </div>

                            <!-- Year -->
                            <div>
                                <x-input-label for="year" value="Year Created" class="mb-2" />
                                <x-text-input id="year" name="year" type="text" class="block w-full" placeholder="e.g., {{ date('Y') }}" />
                                <x-input-error class="mt-2" :messages="$errors->get('year')" />
                            </div>
                        </div>

                         <!-- Description -->
                        <div>
                            <x-input-label for="description" value="Description & Context" class="mb-2" />
                            <textarea name="description" id="description" rows="5"
                                class="w-full py-3 px-4 bg-gray-800 border border-gray-600 text-white rounded-lg shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500/50 transition-all duration-200 placeholder-gray-500"
                                placeholder="Describe the concept, inspiration, and details of the work..."></textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <!-- Image Upload -->
                        <div>
                            <x-input-label for="image" value="Artwork Image *" class="mb-2" />
                            <x-file-input id="image" accept="image/*" required />
                            <x-input-error class="mt-2" :messages="$errors->get('image')" />
                        </div>

                        <div class="flex justify-end pt-4 border-t border-gray-700">
                            <x-primary-button>
                                Publish Artwork
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
