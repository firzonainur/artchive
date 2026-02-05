<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Publish Research') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 p-8 rounded-xl border border-gray-700 shadow-xl">
                 <form action="{{ route('research.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Title -->
                    <div>
                        <x-input-label for="title" value="Paper Title *" class="text-lg mb-2" />
                        <x-text-input id="title" name="title" type="text" class="block w-full text-lg" placeholder="e.g., The Influence of Digital Media on Abstract Forms" required />
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                    </div>

                    <!-- Abstract -->
                     <div>
                        <x-input-label for="abstract" value="Abstract *" class="mb-2" />
                        <textarea name="abstract" id="abstract" rows="6"
                            class="w-full py-3 px-4 bg-gray-800 border border-gray-600 text-white rounded-lg shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500/50 transition-all duration-200 placeholder-gray-500"
                            placeholder="Provide a summary of the research..."></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('abstract')" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                         <!-- File Upload -->
                        <div>
                            <x-input-label for="publication_file" value="PDF File (Max 10MB)" class="mb-2" />
                            <x-file-input id="publication_file" accept=".pdf" />
                            <x-input-error class="mt-2" :messages="$errors->get('publication_file')" />
                        </div>

                         <!-- External Link -->
                        <div>
                            <x-input-label for="external_link" value="External DOI / Link" class="mb-2" />
                            <x-text-input id="external_link" name="external_link" type="url" class="block w-full" placeholder="https://doi.org/..." />
                            <x-input-error class="mt-2" :messages="$errors->get('external_link')" />
                        </div>
                    </div>

                    <!-- Related Artworks (Multi-select) -->
                    <div>
                        <x-input-label for="artworks" value="Related Artworks (Hold Ctrl/Cmd to select multiple)" class="mb-2" />
                        <select name="artworks[]" id="artworks" multiple
                            class="w-full py-3 px-4 bg-gray-800 border border-gray-600 text-white rounded-lg shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500/50 transition-all duration-200 h-48">
                            @foreach($artworks as $artwork)
                                <option value="{{ $artwork->id }}">{{ $artwork->title }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-2">Select the artworks from the archive that this paper discusses.</p>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-700">
                        <x-primary-button>
                            Publish Paper
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
