<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('General Settings') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="settingsManager({{ $chatbotEnabled ? 'true' : 'false' }})">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    
                    <!-- Success Message -->
                    <div x-show="showSuccess" 
                         x-transition
                         class="mb-4 bg-green-500/10 border border-green-500 text-green-500 px-4 py-3 rounded-lg flex items-center justify-between" 
                         role="alert">
                        <span class="block sm:inline">Settings updated successfully!</span>
                        <button @click="showSuccess = false" class="text-green-500 hover:text-green-400">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Error Message -->
                    <div x-show="showError" 
                         x-transition
                         class="mb-4 bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded-lg flex items-center justify-between" 
                         role="alert">
                        <span class="block sm:inline">Failed to update settings. Please try again.</span>
                        <button @click="showError = false" class="text-red-500 hover:text-red-400">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="bg-gray-700/50 p-6 rounded-xl border border-gray-600">
                        <h3 class="text-lg font-medium text-white mb-4">Chatbot Configuration</h3>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="font-medium text-white">Enable AI Chatbot</div>
                                <div class="text-sm text-gray-400">Allow users to interact with the Academic AI assistant.</div>
                            </div>
                            
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       @change="toggleChatbot" 
                                       x-model="chatbotEnabled" 
                                       :disabled="isUpdating"
                                       class="sr-only peer">
                                <div class="w-14 h-7 bg-gray-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-purple-600 peer-disabled:opacity-50 peer-disabled:cursor-not-allowed"></div>
                                <span class="ml-3 text-sm font-medium" 
                                      :class="chatbotEnabled ? 'text-white' : 'text-gray-400'"
                                      x-text="chatbotEnabled ? 'Active' : 'Disabled'">
                                </span>
                                <svg x-show="isUpdating" class="ml-2 animate-spin h-4 w-4 text-purple-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </label>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function settingsManager(initialState) {
            return {
                chatbotEnabled: initialState,
                isUpdating: false,
                showSuccess: false,
                showError: false,

                toggleChatbot() {
                    this.isUpdating = true;
                    this.showSuccess = false;
                    this.showError = false;

                    fetch('{{ route('admin.settings.update') }}', {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            chatbot_enabled: this.chatbotEnabled ? 'on' : 'off'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.showSuccess = true;
                            
                            // Notify other tabs/windows
                            localStorage.setItem('chatbot_enabled_changed', Date.now().toString());
                            
                            setTimeout(() => {
                                this.showSuccess = false;
                            }, 3000);
                        } else {
                            this.showError = true;
                            this.chatbotEnabled = !this.chatbotEnabled; // Revert the toggle
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        this.showError = true;
                        this.chatbotEnabled = !this.chatbotEnabled; // Revert the toggle
                    })
                    .finally(() => {
                        this.isUpdating = false;
                    });
                }
            }
        }
    </script>
</x-admin-layout>
