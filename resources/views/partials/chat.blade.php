{{-- ===================== CHAT HUB (POTA AI & SELLER) ===================== --}}
<button id="live-chat-toggle" class="fixed bottom-4 right-4 md:bottom-6 md:right-6 bg-brand-600 text-white p-1 pr-4 md:pr-5 rounded-full shadow-[0_10px_30px_rgba(37,99,235,0.4)] hover:shadow-[0_15px_40px_rgba(37,99,235,0.6)] transition-all duration-300 z-[999] flex items-center gap-2 md:gap-3 group overflow-hidden outline-none hover:-translate-y-1" onclick="toggleChatWindow()">
    <div class="bg-white text-brand-600 w-12 h-12 md:w-14 md:h-14 rounded-full relative flex items-center justify-center shadow-inner">
        <div class="absolute inset-0 rounded-full animate-pulse-glow opacity-0 group-hover:opacity-100 transition-opacity border-2 border-brand-400"></div>
        <i class="fas fa-comments text-xl md:text-2xl relative z-10 group-hover:scale-110 transition-transform"></i>
        <div class="absolute top-0 right-0 w-3 h-3 bg-red-500 rounded-full border-2 border-white animate-bounce"></div>
    </div>
    <div class="flex flex-col text-left hidden sm:flex">
        <span class="font-black text-sm md:text-base tracking-wide">Pusat Obrolan</span>
        <span class="text-[10px] md:text-xs text-blue-100 font-bold uppercase tracking-widest">Tanya / Nego</span>
    </div>
</button>

{{-- ===================== MAIN CHAT WINDOW ===================== --}}
<div id="live-chat-window" class="fixed bottom-20 md:bottom-24 right-4 md:right-6 w-[calc(100vw-2rem)] md:w-[800px] h-[80vh] md:h-[600px] bg-white rounded-xl shadow-[0_10px_50px_rgba(0,0,0,0.2)] border border-zinc-200 flex flex-col overflow-hidden z-[999] transition-all duration-500 opacity-0 translate-y-10 scale-95 pointer-events-none hidden origin-bottom-right">

    {{-- Header (Shopee Style: White/Brand bg, Tab Switcher) --}}
    <div class="bg-white border-b border-zinc-200 p-3 md:p-4 flex justify-between items-center shrink-0 z-20 shadow-sm relative">
        <div class="flex items-center gap-4 flex-1">
            <div class="text-brand-600 font-black text-lg md:text-xl tracking-tight flex items-center gap-2">
                <i class="fas fa-comments text-xl"></i> Chat
            </div>

            {{-- TAB SWITCHER ELEGAN (IOS Style) --}}
            <div class="flex bg-zinc-100 rounded-lg p-1 relative z-20 w-[180px] md:w-[220px]">
                <button onclick="switchChatTab('seller')" id="tab-btn-seller" class="flex-1 relative z-10 px-2 py-1.5 md:py-2 text-[10px] md:text-xs font-black uppercase tracking-widest rounded-md transition-all outline-none text-brand-600 bg-white shadow-sm">
                    <i class="fas fa-store mr-1"></i> Penjual
                </button>
                <button onclick="switchChatTab('ai')" id="tab-btn-ai" class="flex-1 relative z-10 px-2 py-1.5 md:py-2 text-[10px] md:text-xs font-black uppercase tracking-widest rounded-md transition-all outline-none text-zinc-500 hover:text-zinc-800">
                    <i class="fas fa-robot mr-1"></i> POTA AI
                </button>
            </div>
        </div>

        <div class="flex items-center gap-1 md:gap-2">
            <button class="w-8 h-8 rounded hover:bg-zinc-100 text-zinc-500 transition-all outline-none"><i class="fas fa-arrow-right-to-bracket"></i></button>
            <button onclick="toggleFullScreen()" class="w-8 h-8 rounded hover:bg-zinc-100 text-zinc-500 transition-all outline-none hidden sm:flex"><i id="icon-resize" class="fas fa-expand"></i></button>
            <button onclick="toggleChatWindow()" class="w-8 h-8 rounded hover:bg-red-50 text-zinc-500 hover:text-red-500 transition-all outline-none"><i class="fas fa-chevron-down"></i></button>
        </div>
    </div>

    {{-- KONTEN UTAMA (TUMPUKAN ABSOLUTE UNTUK ANIMASI SMOOTH) --}}
    <div class="relative flex-1 overflow-hidden bg-zinc-50">

        {{-- ==========================================
             TAB 1: SELLER VIEW (SPLIT PANE)
             ========================================== --}}
        <div id="view-seller" class="absolute inset-0 flex flex-row transition-all duration-500 ease-[cubic-bezier(0.4,0,0.2,1)] opacity-100 scale-100 pointer-events-auto">

            {{-- LEFT PANE: Contact List --}}
            <div class="w-[280px] sm:w-[300px] border-r border-zinc-200 bg-white flex flex-col shrink-0">
                {{-- Search Area --}}
                <div class="p-3 border-b border-zinc-100">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-zinc-400 text-xs"></i>
                        <input type="text" placeholder="Cari nama toko..." class="w-full bg-zinc-100 text-xs text-zinc-700 rounded-md pl-8 pr-3 py-2 outline-none focus:ring-1 focus:ring-brand-500">
                    </div>
                </div>

                {{-- Contact List (Data Asli dari DB akan dirender di sini via JS) --}}
                <div id="seller-contact-list" class="flex-1 overflow-y-auto custom-scrollbar">
                    {{-- Loading State --}}
                    <div class="p-8 text-center text-zinc-400">
                        <i class="fas fa-circle-notch fa-spin text-2xl mb-2"></i>
                        <p class="text-xs">Memuat kontak...</p>
                    </div>
                </div>
            </div>

            {{-- RIGHT PANE: Chat Area --}}
            <div class="flex-1 bg-zinc-50/50 flex flex-col relative">

                {{-- STATE 1: EMPTY STATE (Welcome Screen Shopee) --}}
                <div id="seller-empty-state" class="absolute inset-0 flex flex-col items-center justify-center bg-zinc-50 z-20">
                    <img src="https://cdngarenanow-a.akamaihd.net/shopee/shopee-seller-live-sg/build-web-chat/0b8e612f170e70ab2f25.png" alt="Welcome Chat" class="w-48 mb-6 opacity-80">
                    <h3 class="text-xl font-bold text-zinc-700 mb-2">Selamat Datang di Pusat Obrolan</h3>
                    <p class="text-sm text-zinc-500">Pilih kontak di sebelah kiri untuk mulai bernegosiasi.</p>
                </div>

                {{-- STATE 2: ACTIVE CHAT --}}
                <div id="seller-active-chat" class="hidden flex-1 flex-col h-full">
                    {{-- Active Store Header --}}
                    <div class="bg-white px-4 py-3 border-b border-zinc-200 flex items-center justify-between shadow-sm shrink-0">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-black" id="active-store-avatar">TK</div>
                            <div>
                                <h4 class="font-bold text-sm text-zinc-900" id="active-store-name">Nama Toko</h4>
                                <p class="text-[10px] text-zinc-500 flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span> Online</p>
                            </div>
                        </div>
                        <button class="text-zinc-400 hover:text-brand-600 outline-none"><i class="fas fa-store"></i></button>
                    </div>

                    {{-- Message History Area --}}
                    <div id="seller-chat-messages" class="flex-1 p-5 overflow-y-auto custom-scrollbar flex flex-col gap-4">
                        {{-- Pesan akan dirender di sini via JS --}}
                    </div>

                    {{-- Input Area (Shopee style) --}}
                    <div class="p-3 md:p-4 bg-white border-t border-zinc-200 shrink-0">
                        <div class="flex gap-3 mb-2 px-1">
                            <button class="text-zinc-400 hover:text-brand-600 outline-none"><i class="far fa-image text-lg"></i></button>
                            <button class="text-zinc-400 hover:text-brand-600 outline-none"><i class="far fa-folder text-lg"></i></button>
                            <button class="text-zinc-400 hover:text-brand-600 outline-none"><i class="far fa-face-smile text-lg"></i></button>
                        </div>
                        <div class="flex items-end gap-2 bg-white border border-zinc-300 rounded-lg p-1 focus-within:border-brand-500 focus-within:ring-1 focus-within:ring-brand-500 transition-all">
                            <textarea id="seller-chat-input" rows="1" placeholder="Ketik pesan untuk penjual..." class="w-full text-sm text-zinc-700 bg-transparent px-3 py-2 outline-none resize-none max-h-[100px] min-h-[40px]"></textarea>
                            <button onclick="sendSellerMessage()" class="w-10 h-10 rounded-md bg-brand-600 text-white flex items-center justify-center shrink-0 hover:bg-brand-700 transition-colors outline-none disabled:opacity-50">
                                <i class="fas fa-paper-plane text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- ==========================================
             TAB 2: AI VIEW (POTA)
             ========================================== --}}
        <div id="view-ai" class="absolute inset-0 flex flex-col bg-white transition-all duration-500 ease-[cubic-bezier(0.4,0,0.2,1)] opacity-0 scale-95 pointer-events-none z-10">

            {{-- AI Sub-Header --}}
            <div class="bg-zinc-900 text-white p-3 md:p-4 flex justify-between items-center shrink-0 shadow-md">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center border-2 border-zinc-800 shadow-[0_0_15px_rgba(37,99,235,0.5)]">
                        <i class="fas fa-robot text-white text-sm"></i>
                    </div>
                    <div>
                        <h4 class="font-black tracking-wide text-sm">Mandor POTA AI</h4>
                        <p class="text-[10px] text-blue-300 font-bold tracking-wider uppercase flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Sistem Analisa Aktif
                        </p>
                    </div>
                </div>
                <button onclick="startVoiceCallMode()" class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all outline-none border border-white/10">
                    <i class="fas fa-microphone"></i>
                </button>
            </div>

            <div class="flex-1 p-5 overflow-y-auto custom-scrollbar bg-slate-50 bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px] flex flex-col gap-4" id="ai-chat-messages">
                <div class="text-[10px] text-center text-zinc-400 font-bold uppercase tracking-widest mb-2">Asisten Cerdas Terhubung</div>

                <div class="flex gap-3 max-w-[85%]">
                    <div class="w-8 h-8 rounded-full bg-blue-600 flex-shrink-0 flex items-center justify-center text-white text-xs shadow-md"><i class="fas fa-robot"></i></div>
                    <div class="bg-white border border-zinc-200 text-zinc-800 p-4 rounded-2xl rounded-tl-sm text-sm shadow-sm relative font-medium leading-relaxed">
                        Halo {{ auth()->user()?->nama ?? 'Juragan' }}! Saya POTA. Mau hitung RAB proyek, cari rekomendasi baja ringan, atau bandingkan harga semen hari ini?
                    </div>
                </div>
            </div>

            <div class="p-4 bg-white border-t border-zinc-200 shrink-0 relative z-20">
                <div class="flex items-center gap-2 relative">
                    <button id="ai-voice-btn" onclick="toggleAIVoice()" class="w-12 h-12 rounded-full bg-zinc-100 text-zinc-500 hover:bg-blue-50 hover:text-blue-600 flex items-center justify-center transition-all shrink-0 outline-none">
                        <i class="fas fa-microphone text-lg"></i>
                    </button>
                    <input type="text" id="ai-chat-input" placeholder="Tanya apapun tentang material..." class="flex-1 bg-zinc-100 text-sm font-medium rounded-full pl-5 pr-14 py-3.5 outline-none focus:ring-2 focus:ring-blue-500 border border-transparent transition-all" onkeypress="handleAIEnter(event)">
                    <button id="send-ai-btn" onclick="sendAIMessage()" class="absolute right-2 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-blue-600 text-white hover:bg-blue-700 flex items-center justify-center transition-colors outline-none shadow-md shadow-blue-500/30">
                        <i class="fas fa-paper-plane text-sm"></i>
                    </button>
                </div>
            </div>

            {{-- Voice Call Overlay (Khusus AI) --}}
            <div id="ai-voice-overlay" class="absolute inset-0 bg-zinc-950/95 backdrop-blur-xl z-[100] hidden flex-col items-center justify-center text-white">
                <div class="text-xs font-black tracking-widest text-blue-400 uppercase mb-16" id="ai-voice-status">AI Mendengarkan...</div>
                <div class="relative w-32 h-32 flex items-center justify-center mb-16">
                    <div class="absolute inset-0 bg-blue-600/30 rounded-full animate-ping duration-1000"></div>
                    <div id="ai-voice-visualizer" class="w-24 h-24 rounded-full bg-blue-600 flex items-center justify-center text-white text-3xl shadow-[0_0_50px_rgba(37,99,235,0.6)] z-10 transition-all duration-500">
                        <i class="fas fa-microphone"></i>
                    </div>
                </div>
                <button onclick="endVoiceCallMode()" class="bg-red-500 text-white hover:bg-red-600 px-8 py-3 rounded-full font-bold flex items-center gap-2 transition-all group text-sm outline-none shadow-lg shadow-red-500/30">
                    <i class="fas fa-phone-slash"></i> Akhiri Panggilan AI
                </button>
            </div>
        </div>

    </div>
</div>

<script>
    /* ========================================================
       1. GLOBAL CHAT WINDOW & TAB SWITCHER LOGIC
       ======================================================== */
    const chatWindow = document.getElementById('live-chat-window');
    const viewSeller = document.getElementById('view-seller');
    const viewAI = document.getElementById('view-ai');
    const tabSeller = document.getElementById('tab-btn-seller');
    const tabAI = document.getElementById('tab-btn-ai');

    let currentStoreId = null;

    // Restore State from Session
    document.addEventListener('DOMContentLoaded', () => {
        const isOpen = sessionStorage.getItem('pota_chat_open') === 'true';
        const activeTab = sessionStorage.getItem('pota_chat_tab') || 'seller';

        if(isOpen && chatWindow) {
            chatWindow.classList.remove('hidden', 'opacity-0', 'translate-y-10', 'scale-95', 'pointer-events-none');
            chatWindow.classList.add('flex', 'opacity-100', 'translate-y-0', 'scale-100');
            if(activeTab === 'ai') switchChatTab('ai'); else switchChatTab('seller');
        }

        // Initialize Seller Contacts on load
        fetchSellerContacts();
        restoreAIMessages();
    });

    function toggleChatWindow() {
        if(chatWindow.classList.contains('hidden')) {
            const lastTab = sessionStorage.getItem('pota_chat_tab') || 'seller';
            switchChatTab(lastTab);

            chatWindow.classList.remove('hidden', 'opacity-0', 'translate-y-10', 'scale-95', 'pointer-events-none');
            chatWindow.classList.add('flex', 'opacity-100', 'translate-y-0', 'scale-100');
            sessionStorage.setItem('pota_chat_open', 'true');
        } else {
            chatWindow.classList.add('opacity-0', 'translate-y-10', 'scale-95', 'pointer-events-none');
            chatWindow.classList.remove('opacity-100', 'translate-y-0', 'scale-100');
            setTimeout(() => chatWindow.classList.add('hidden'), 500);
            sessionStorage.setItem('pota_chat_open', 'false');
        }
    }

    function switchChatTab(tabName) {
        sessionStorage.setItem('pota_chat_tab', tabName);

        if(tabName === 'ai') {
            // Animasi transisi ke AI (Single Pane)
            viewSeller.classList.replace('opacity-100', 'opacity-0');
            viewSeller.classList.replace('scale-100', 'scale-95');
            viewSeller.classList.replace('pointer-events-auto', 'pointer-events-none');
            setTimeout(() => { viewSeller.style.display = 'none'; viewAI.style.display = 'flex'; }, 300); // Wait fade out

            setTimeout(() => {
                viewAI.classList.replace('opacity-0', 'opacity-100');
                viewAI.classList.replace('scale-95', 'scale-100');
                viewAI.classList.replace('pointer-events-none', 'pointer-events-auto');
                document.getElementById('ai-chat-input').focus();
            }, 350);

            // Styling Tabs
            tabAI.className = "flex-1 relative z-10 px-2 py-1.5 md:py-2 text-[10px] md:text-xs font-black uppercase tracking-widest rounded-md transition-all outline-none text-blue-600 bg-white shadow-sm";
            tabSeller.className = "flex-1 relative z-10 px-2 py-1.5 md:py-2 text-[10px] md:text-xs font-black uppercase tracking-widest rounded-md transition-all outline-none text-zinc-500 hover:text-zinc-800";
        }
        else {
            // Animasi transisi ke Seller (Split Pane)
            viewAI.classList.replace('opacity-100', 'opacity-0');
            viewAI.classList.replace('scale-100', 'scale-95');
            viewAI.classList.replace('pointer-events-auto', 'pointer-events-none');
            setTimeout(() => { viewAI.style.display = 'none'; viewSeller.style.display = 'flex'; }, 300);

            setTimeout(() => {
                viewSeller.classList.replace('opacity-0', 'opacity-100');
                viewSeller.classList.replace('scale-95', 'scale-100');
                viewSeller.classList.replace('pointer-events-none', 'pointer-events-auto');
            }, 350);

            // Styling Tabs
            tabSeller.className = "flex-1 relative z-10 px-2 py-1.5 md:py-2 text-[10px] md:text-xs font-black uppercase tracking-widest rounded-md transition-all outline-none text-brand-600 bg-white shadow-sm";
            tabAI.className = "flex-1 relative z-10 px-2 py-1.5 md:py-2 text-[10px] md:text-xs font-black uppercase tracking-widest rounded-md transition-all outline-none text-zinc-500 hover:text-zinc-800";
        }
    }

    function toggleFullScreen() {
        chatWindow.classList.toggle('md:w-[800px]');
        chatWindow.classList.toggle('md:h-[600px]');
        chatWindow.classList.toggle('w-[95vw]');
        chatWindow.classList.toggle('h-[90vh]');
        const icon = document.getElementById('icon-resize');
        if(icon) icon.className = chatWindow.classList.contains('w-[95vw]') ? 'fas fa-compress' : 'fas fa-expand';
    }


    /* ========================================================
       2. SELLER CHAT LOGIC (API INTEGRATION)
       ======================================================== */
    async function fetchSellerContacts() {
        const contactList = document.getElementById('seller-contact-list');
        try {
            // Panggil API Laravel
            const res = await fetch('/api/chat/contacts');
            if(!res.ok) throw new Error("Gagal load kontak");
            const data = await res.json();

            contactList.innerHTML = ''; // Bersihkan loading state

            if(data.length === 0) {
                contactList.innerHTML = `<div class="p-6 text-center text-zinc-400 text-xs">Belum ada obrolan.</div>`;
                return;
            }

            data.forEach(toko => {
                const initial = toko.nama_toko.substring(0, 2).toUpperCase();
                let badgeHTML = toko.unread_count > 0 ? `<div class="bg-red-500 text-white text-[9px] font-black w-4 h-4 rounded-full flex items-center justify-center">${toko.unread_count}</div>` : '';

                let html = `
                <div onclick="openStoreChat(${toko.store_id}, '${toko.nama_toko}', '${initial}')" class="flex items-center gap-3 p-3 hover:bg-zinc-50 border-b border-zinc-100 cursor-pointer transition-colors group">
                    <div class="w-10 h-10 rounded-full bg-zinc-200 text-zinc-600 flex items-center justify-center font-bold text-sm shrink-0">${initial}</div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-center mb-0.5">
                            <h4 class="text-xs font-bold text-zinc-900 truncate group-hover:text-brand-600">${toko.nama_toko}</h4>
                            <span class="text-[9px] text-zinc-400 shrink-0 ml-2">${toko.last_time}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <p class="text-[10px] text-zinc-500 truncate pr-2">${toko.last_message}</p>
                            ${badgeHTML}
                        </div>
                    </div>
                </div>`;
                contactList.insertAdjacentHTML('beforeend', html);
            });
        } catch(e) {
            console.error(e);
            contactList.innerHTML = `<div class="p-6 text-center text-red-400 text-xs">Gagal mengambil data kontak.</div>`;
        }
    }

    async function openStoreChat(storeId, storeName, initials) {
        currentStoreId = storeId;

        // Ganti View
        document.getElementById('seller-empty-state').classList.add('hidden');
        document.getElementById('seller-active-chat').classList.remove('hidden');
        document.getElementById('seller-active-chat').classList.add('flex');

        // Update Header
        document.getElementById('active-store-name').innerText = storeName;
        document.getElementById('active-store-avatar').innerText = initials;

        // Fetch Messages
        const msgContainer = document.getElementById('seller-chat-messages');
        msgContainer.innerHTML = `<div class="text-center text-xs text-zinc-400 my-4"><i class="fas fa-spinner fa-spin"></i> Memuat histori...</div>`;

        try {
            const res = await fetch(`/api/chat/messages/${storeId}`);
            const data = await res.json();

            msgContainer.innerHTML = '';
            data.forEach(msg => {
                appendSellerMessage(msg.text, msg.sender, msg.time);
            });
            msgContainer.scrollTop = msgContainer.scrollHeight;
        } catch(e) {
            msgContainer.innerHTML = `<div class="text-center text-xs text-red-400 my-4">Gagal memuat histori chat.</div>`;
        }
    }

    function appendSellerMessage(text, sender, time) {
        const msgContainer = document.getElementById('seller-chat-messages');
        let html = '';
        if(sender === 'user') {
            html = `
            <div class="flex justify-end gap-2 max-w-[85%] self-end">
                <div class="flex flex-col items-end">
                    <div class="bg-brand-100 border border-brand-200 text-brand-900 p-3 rounded-2xl rounded-tr-sm text-sm shadow-sm leading-relaxed">${text}</div>
                    <span class="text-[9px] text-zinc-400 mt-1">${time}</span>
                </div>
            </div>`;
        } else {
            html = `
            <div class="flex justify-start gap-2 max-w-[85%]">
                <div class="flex flex-col items-start">
                    <div class="bg-white border border-zinc-200 text-zinc-800 p-3 rounded-2xl rounded-tl-sm text-sm shadow-sm leading-relaxed">${text}</div>
                    <span class="text-[9px] text-zinc-400 mt-1">${time}</span>
                </div>
            </div>`;
        }
        msgContainer.insertAdjacentHTML('beforeend', html);
        msgContainer.scrollTop = msgContainer.scrollHeight;
    }

    async function sendSellerMessage() {
        const input = document.getElementById('seller-chat-input');
        const text = input.value.trim();
        if(!text || !currentStoreId) return;

        // Optimistic UI (tampilkan langsung)
        const timeNow = new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'});
        appendSellerMessage(text, 'user', timeNow);
        input.value = '';

        try {
            await fetch('/api/chat/send', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ message: text, store_id: currentStoreId })
            });
            // Opsional: Refresh contact list to show new last_message
        } catch(e) {
            alert("Pesan gagal dikirim.");
        }
    }

    // Bind Enter key to textarea
    document.getElementById('seller-chat-input').addEventListener('keypress', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendSellerMessage();
        }
    });


    /* ========================================================
       3. AI CHAT LOGIC (POTA) - Tidak diubah logicnya
       ======================================================== */
    const aiMessagesContainer = document.getElementById('ai-chat-messages');
    const aiInput = document.getElementById('ai-chat-input');
    let aiChatHistory = [];

    function restoreAIMessages() {
        const savedDOM = sessionStorage.getItem('pota_ai_dom');
        if(savedDOM && aiMessagesContainer) {
            aiMessagesContainer.innerHTML = savedDOM;
            aiMessagesContainer.scrollTop = aiMessagesContainer.scrollHeight;
        }
    }

    function saveAIState() {
        if(aiMessagesContainer) sessionStorage.setItem('pota_ai_dom', aiMessagesContainer.innerHTML);
    }

    function appendAIMessage(text, sender) {
        if(!aiMessagesContainer) return;
        const div = document.createElement('div');
        if(sender === 'bot') {
            div.className = "flex gap-3 max-w-[85%] origin-bottom-left animate-[scale-in-bl_0.3s_both]";
            const clean = text.replace(/"/g, "'").replace(/\n/g, " ").replace(/<[^>]*>?/gm, '');
            div.innerHTML = `
                <div class="w-8 h-8 rounded-full bg-blue-600 flex-shrink-0 flex items-center justify-center text-white text-xs shadow-md mt-auto"><i class="fas fa-robot"></i></div>
                <div class="bg-white border border-zinc-200 text-zinc-800 p-4 rounded-2xl rounded-bl-sm text-sm shadow-sm relative group font-medium leading-relaxed">
                    ${text}
                    <button onclick="speakText('${clean}')" class="absolute -right-8 bottom-1 w-6 h-6 rounded-full text-zinc-400 hover:text-blue-500 opacity-0 group-hover:opacity-100 transition-all outline-none"><i class="fas fa-volume-up text-xs"></i></button>
                </div>`;
        } else {
            div.className = "flex max-w-[85%] self-end origin-bottom-right animate-[scale-in-br_0.3s_both]";
            div.innerHTML = `<div class="bg-zinc-900 text-white p-4 rounded-2xl rounded-br-sm text-sm font-medium shadow-md">${text}</div>`;
        }
        aiMessagesContainer.appendChild(div);
        aiMessagesContainer.scrollTop = aiMessagesContainer.scrollHeight;
        saveAIState();
    }

    async function sendAIMessage(textOverride = null) {
        if(!aiInput) return;
        const text = textOverride || aiInput.value.trim();
        if(!text) return;
        if(!textOverride) { appendAIMessage(text, 'user'); aiInput.value = ''; }
        aiChatHistory.push({sender:'user', text:text});

        if(!isCallMode) {
            const loadDiv = document.createElement('div');
            loadDiv.id = 'ai-loading';
            loadDiv.className = 'flex gap-1.5 ml-12 items-center text-blue-500 my-2';
            loadDiv.innerHTML = '<span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce"></span><span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></span><span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 0.4s"></span>';
            aiMessagesContainer.appendChild(loadDiv);
            aiMessagesContainer.scrollTop = aiMessagesContainer.scrollHeight;
        }

        try {
            const res = await fetch('/api/chat', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({message: text, history: aiChatHistory.slice(-6)})
            });
            if (!res.ok) throw new Error("Gagal terhubung ke otak POTA.");
            const data = await res.json();

            if(!isCallMode && document.getElementById('ai-loading')) document.getElementById('ai-loading').remove();
            appendAIMessage(data.reply, 'bot');
            aiChatHistory.push({sender:'bot', text: data.reply.replace(/<[^>]*>?/gm, '')});
            if(isCallMode) speakText(data.reply, true);

        } catch(e) {
            if(document.getElementById('ai-loading')) document.getElementById('ai-loading').remove();
            appendAIMessage("⚠️ " + e.message, 'bot');
        }
    }

    function handleAIEnter(e) { if(e.key === 'Enter') sendAIMessage(); }

    /* Voice Logic Setup */
    let recognition = null;
    let isCallMode = false;
    if (window.SpeechRecognition || window.webkitSpeechRecognition) {
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        recognition = new SpeechRecognition();
        recognition.lang = 'id-ID';
        recognition.onresult = (event) => {
            const text = event.results[0][0].transcript;
            if(isCallMode) {
                document.getElementById('ai-voice-status').innerText = "Menganalisa...";
                document.getElementById('ai-voice-visualizer').classList.remove('animate-pulse');
                sendAIMessage(text);
            } else {
                aiInput.value = text;
                document.getElementById('ai-voice-btn').classList.remove('bg-blue-600','text-white','animate-pulse');
            }
        };
    }

    function toggleAIVoice() {
        if(!recognition) return alert("Browser tidak mendukung mic.");
        const btn = document.getElementById('ai-voice-btn');
        if(btn.classList.contains('bg-blue-600')) { recognition.stop(); btn.classList.remove('bg-blue-600','text-white','animate-pulse'); }
        else { recognition.start(); btn.classList.add('bg-blue-600','text-white','animate-pulse'); }
    }

    function startVoiceCallMode() {
        if(!recognition) return alert("Browser tidak mendukung.");
        isCallMode = true;
        document.getElementById('ai-voice-overlay').classList.replace('hidden', 'flex');
        speakText("Halo! POTA siap membantu proyek Anda.", true);
    }

    function endVoiceCallMode() {
        isCallMode = false;
        document.getElementById('ai-voice-overlay').classList.replace('flex', 'hidden');
        window.speechSynthesis.cancel();
        if(recognition) recognition.stop();
    }

    function speakText(text, autoListen = false) {
        window.speechSynthesis.cancel();
        const u = new SpeechSynthesisUtterance(text.replace(/<[^>]*>?/gm, ''));
        u.lang = 'id-ID';
        u.onend = () => { if(isCallMode && autoListen) { recognition.start(); document.getElementById('ai-voice-status').innerText = "Silakan bicara..."; }};
        window.speechSynthesis.speak(u);
    }

    // CSS Animations
    const style = document.createElement('style');
    style.innerHTML = `@keyframes scale-in-bl { 0% { transform: scale(0); opacity: 0; } 100% { transform: scale(1); opacity: 1; } } @keyframes scale-in-br { 0% { transform: scale(0); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }`;
    document.head.appendChild(style);

</script>
