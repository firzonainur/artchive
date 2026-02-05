<div x-data="chatbotWidget()" 
     x-show="isEnabled"
     x-cloak
     class="fixed bottom-6 right-6 z-50 flex flex-col items-end gap-4">

    <!-- Chat Window -->
    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-10 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-10 scale-95"
         class="bg-gray-800 border border-gray-700 rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden flex flex-col h-[500px]">
        
        <!-- Header -->
        <div class="bg-gray-900 border-b border-gray-700 p-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-cyan-400 to-purple-500 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-100">AI Assistant</h3>
                    <p class="text-xs text-gray-400 flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-green-500"></span> Online
                    </p>
                </div>
            </div>
            <button @click="isOpen = false" class="text-gray-400 hover:text-white transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Messages Area -->
        <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-900/50" x-ref="messagesContainer">
            <template x-for="(msg, index) in messages" :key="index">
                <div :class="{'flex justify-end': msg.sender === 'user', 'flex justify-start': msg.sender === 'ai'}">
                    <div :class="{
                        'bg-purple-600 text-white': msg.sender === 'user',
                        'bg-gray-700 text-gray-200': msg.sender === 'ai'
                    }" class="relative max-w-[80%] rounded-2xl px-4 py-2 text-sm shadow-md leading-relaxed whitespace-pre-wrap"
                       x-html="msg.text">
                    </div>
                </div>
            </template>
            
            <div x-show="isLoading" class="flex justify-start">
                <div class="bg-gray-700 text-gray-200 rounded-2xl px-4 py-2 flex gap-1">
                    <span class="w-2 h-2 rounded-full bg-gray-400 animate-bounce"></span>
                    <span class="w-2 h-2 rounded-full bg-gray-400 animate-bounce" style="animation-delay: 0.2s"></span>
                    <span class="w-2 h-2 rounded-full bg-gray-400 animate-bounce" style="animation-delay: 0.4s"></span>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="bg-gray-800 p-3 border-t border-gray-700">
            <form @submit.prevent="sendMessage" class="flex gap-2">
                <input type="text" 
                       x-model="userInput" 
                       class="flex-1 bg-gray-900 border border-gray-700 rounded-xl px-4 py-2 text-gray-100 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 placeholder-gray-500 text-sm"
                       placeholder="Type your message..."
                       :disabled="isLoading">
                <button type="submit" 
                        class="bg-purple-600 hover:bg-purple-500 text-white rounded-xl p-2 transition disabled:opacity-50 disabled:cursor-not-allowed"
                        :disabled="!userInput.trim() || isLoading">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <!-- Floating Toggle Button -->
    <button @click="isOpen = !isOpen" 
            :class="{'rotate-45': isOpen}"
            class="bg-gradient-to-r from-purple-600 to-cyan-500 hover:from-purple-500 hover:to-cyan-400 text-white p-3 rounded-full shadow-lg transition-all duration-300 hover:scale-105 active:scale-95 group">
        <svg x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
        </svg>
        <svg x-show="isOpen" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>

<script>
    function chatbotWidget() {
        return {
            isOpen: false,
            isLoading: false,
            isEnabled: true, // Will be updated on init
            userInput: '',
            messages: [
                { sender: 'ai', text: 'Halo! Ada yang bisa saya bantu hari ini?' }
            ],

            init() {
                this.$watch('messages', () => {
                   this.scrollToBottom();
                });

                // Check initial status
                this.checkStatus();

                // Poll for status changes every 3 seconds
                setInterval(() => {
                    this.checkStatus();
                }, 3000);

                // Listen for storage events (cross-tab communication)
                window.addEventListener('storage', (e) => {
                    if (e.key === 'chatbot_enabled_changed') {
                        this.checkStatus();
                        localStorage.removeItem('chatbot_enabled_changed');
                    }
                });
            },

            checkStatus() {
                fetch('/api/chatbot/status', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    this.isEnabled = data.enabled;
                })
                .catch(error => {
                    console.error('Error checking chatbot status:', error);
                });
            },

            scrollToBottom() {
                this.$nextTick(() => {
                    const container = this.$refs.messagesContainer;
                    container.scrollTop = container.scrollHeight;
                });
            },

            sendMessage() {
                const message = this.userInput.trim();
                if (!message) return;

                // Add user message to chat
                this.messages.push({ sender: 'user', text: message });
                this.userInput = '';
                this.isLoading = true;

                fetch('{{ route('chatbot.chat') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ message: message })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let formattedResponse = data.message;
                        
                        // Bold: **text** -> <strong>text</strong>
                        formattedResponse = formattedResponse.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
                        
                        // Links: [text](url) -> <a href="url">text</a>
                        formattedResponse = formattedResponse.replace(/\[([^\]]+)\]\(([^)]+)\)/g, '<a href="$2" target="_blank" class="text-cyan-400 hover:text-cyan-300 underline">$1</a>');
                        
                        this.messages.push({ sender: 'ai', text: formattedResponse });
                    } else {
                        this.messages.push({ sender: 'ai', text: 'Maaf, terjadi kesalahan. Silakan coba lagi nanti.' });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.messages.push({ sender: 'ai', text: 'Sorry, I lost connection to the server.' });
                })
                .finally(() => {
                    this.isLoading = false;
                });
            }
        }
    }
</script>

