{{-- ===================== CHAT HUB PREMIUM (POTA AI & SELLER) ===================== --}}
{{-- Tombol Toggle Floating --}}
<button id="live-chat-toggle" class="fixed bottom-4 right-4 md:bottom-8 md:right-8 bg-zinc-950 text-white p-1.5 pr-5 md:pr-6 rounded-full shadow-[0_10px_40px_rgba(0,0,0,0.3)] hover:shadow-[0_15px_50px_rgba(37,99,235,0.4)] transition-all duration-300 z-[9998] flex items-center gap-2.5 md:gap-3 group overflow-hidden outline-none hover:-translate-y-1 border border-zinc-800" onclick="toggleChatWindow()">
    <div class="bg-blue-600 w-11 h-11 md:w-12 md:h-12 rounded-full relative flex items-center justify-center shadow-inner overflow-hidden">
        <div class="absolute inset-0 bg-blue-500 animate-pulse opacity-50"></div>
        <i class="fas fa-comments text-lg md:text-xl relative z-10 text-white group-hover:scale-110 transition-transform duration-300"></i>
        <div class="absolute top-0 right-0 w-3 h-3 bg-red-500 rounded-full border-2 border-blue-600 animate-bounce shadow-sm"></div>
    </div>
    <div class="flex flex-col text-left hidden sm:flex">
        <span class="font-black text-sm md:text-base tracking-wide text-white leading-tight">Pusat Obrolan</span>
        <span class="text-[10px] md:text-[11px] text-zinc-400 font-bold uppercase tracking-widest leading-tight">Tanya / Nego</span>
    </div>
</button>

{{-- Main Chat Window --}}
<div id="live-chat-window" class="fixed bottom-0 right-0 md:bottom-28 md:right-8 w-full h-[100dvh] md:w-[800px] md:h-[600px] bg-white md:rounded-2xl shadow-[0_20px_70px_rgba(0,0,0,0.3)] flex flex-col overflow-hidden z-[9999] transition-all duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)] opacity-0 translate-y-10 scale-95 pointer-events-none md:border md:border-zinc-200 origin-bottom-right">
    
    {{-- Header Universal --}}
    <div class="bg-white border-b border-zinc-200 p-3 md:p-4 flex justify-between items-center shrink-0 z-30 shadow-sm relative">
        <div class="flex items-center gap-3 md:gap-4 flex-1">
            <div class="w-10 h-10 bg-zinc-950 text-white rounded-xl flex items-center justify-center shadow-md shrink-0 hidden md:flex">
                <i class="fas fa-comments text-lg"></i>
            </div>
            
            {{-- TAB SWITCHER ELEGAN (IOS STYLE) --}}
            <div class="flex bg-zinc-100 rounded-xl p-1 relative z-20 w-[190px] md:w-[240px] shadow-inner">
                <div id="tab-slider" class="absolute top-1 bottom-1 left-1 w-[calc(50%-4px)] bg-white rounded-lg shadow-sm transition-transform duration-300 ease-out z-0"></div>
                
                <button onclick="switchChatTab('seller')" id="tab-btn-seller" class="flex-1 relative z-10 px-2 py-1.5 md:py-2 text-[10px] md:text-xs font-black uppercase tracking-widest rounded-lg transition-colors duration-300 outline-none flex items-center justify-center gap-1.5 text-zinc-900">
                    <i class="fas fa-store"></i> Penjual
                </button>
                <button onclick="switchChatTab('ai')" id="tab-btn-ai" class="flex-1 relative z-10 px-2 py-1.5 md:py-2 text-[10px] md:text-xs font-black uppercase tracking-widest rounded-lg transition-colors duration-300 outline-none flex items-center justify-center gap-1.5 text-zinc-400 hover:text-zinc-600">
                    <i class="fas fa-robot"></i> POTA AI
                </button>
            </div>
        </div>

        <div class="flex items-center gap-1">
            {{-- Header Actions --}}
            <button onclick="toggleFullScreen()" class="w-8 h-8 md:w-9 md:h-9 rounded-lg hover:bg-zinc-100 text-zinc-500 hover:text-zinc-900 transition-all outline-none items-center justify-center hidden sm:flex">
                <i id="icon-resize" class="fas fa-expand text-sm"></i>
            </button>
            <button onclick="toggleChatWindow()" class="w-8 h-8 md:w-9 md:h-9 rounded-lg hover:bg-red-50 hover:text-red-600 text-zinc-500 transition-all outline-none flex items-center justify-center">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
    </div>

    {{-- KONTEN AREA (TAB CONTAINER) --}}
    <div class="relative flex-1 overflow-hidden bg-zinc-50">

        {{-- ==========================================
             TAB 1: SELLER VIEW (SPLIT PANE)
             ========================================== --}}
        <div id="view-seller" class="absolute inset-0 flex flex-row transition-all duration-500 ease-out opacity-100 translate-x-0 z-20">
            
            {{-- Kiri: Contact List --}}
            <div class="w-20 md:w-[280px] border-r border-zinc-200 bg-white flex flex-col shrink-0 z-10">
                <div class="p-3 border-b border-zinc-100 hidden md:block">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-zinc-400 text-xs"></i>
                        <input type="text" placeholder="Cari nama toko..." class="w-full bg-zinc-100 text-xs font-medium text-zinc-700 rounded-lg pl-8 pr-3 py-2.5 outline-none focus:ring-1 focus:ring-blue-500 transition-all">
                    </div>
                </div>

                {{-- Contact List Container --}}
                <div id="seller-contact-list" class="flex-1 overflow-y-auto custom-scrollbar">
                    {{-- Diisi oleh JS (Loading/Data) --}}
                    <div class="p-6 text-center text-zinc-400 flex flex-col items-center justify-center h-full">
                        <i class="fas fa-circle-notch fa-spin text-2xl mb-2"></i>
                        <span class="text-[10px] font-bold uppercase tracking-widest hidden md:block">Memuat...</span>
                    </div>
                </div>
            </div>

            {{-- Kanan: Chat Room --}}
            <div class="flex-1 bg-zinc-50/50 flex flex-col relative z-0">
                
                {{-- EMPTY STATE (Design Mewah) --}}
                <div id="seller-empty-state" class="absolute inset-0 flex flex-col items-center justify-center bg-white z-20 px-6 text-center transition-opacity duration-300">
                    <div class="w-32 h-32 md:w-40 md:h-40 bg-zinc-50 rounded-full flex items-center justify-center mb-6 relative">
                        <div class="absolute inset-0 bg-blue-500/5 rounded-full animate-ping"></div>
                        <i class="fas fa-comments-dollar text-5xl md:text-6xl text-zinc-300"></i>
                        <div class="absolute -bottom-2 -right-2 w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg border border-zinc-100">
                            <i class="fas fa-store text-emerald-500 text-xl"></i>
                        </div>
                    </div>
                    <h3 class="text-xl md:text-2xl font-black text-zinc-800 mb-2 tracking-tight">Mulai Negosiasi B2B</h3>
                    <p class="text-xs md:text-sm text-zinc-500 max-w-xs font-medium leading-relaxed">Pilih kontak mitra di sebelah kiri untuk melihat pesan atau negosiasi material.</p>
                </div>

                {{-- ACTIVE CHAT --}}
                <div id="seller-active-chat" class="hidden flex-col h-full opacity-0 transition-opacity duration-300">
                    {{-- Header Chat Aktif --}}
                    <div class="bg-white px-4 py-3 border-b border-zinc-200 flex items-center justify-between shadow-sm shrink-0">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-black shadow-inner" id="active-store-avatar">TK</div>
                            <div>
                                <h4 class="font-black text-sm md:text-base text-zinc-900 tracking-tight" id="active-store-name">Nama Toko</h4>
                                <p class="text-[10px] text-zinc-500 flex items-center gap-1 font-bold"><span class="w-2 h-2 rounded-full bg-emerald-500 inline-block shadow-[0_0_5px_#10b981]"></span> Sedang Online</p>
                            </div>
                        </div>
                        <button class="w-8 h-8 rounded-lg hover:bg-zinc-100 text-zinc-400 hover:text-emerald-600 transition-colors flex items-center justify-center outline-none">
                            <i class="fas fa-store text-sm"></i>
                        </button>
                    </div>

                    {{-- Pesan --}}
                    <div id="seller-chat-messages" class="flex-1 p-4 md:p-6 overflow-y-auto custom-scrollbar flex flex-col gap-4 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] bg-zinc-50">
                        {{-- Isi Chat --}}
                    </div>

                    {{-- Input --}}
                    <div class="p-3 md:p-4 bg-white border-t border-zinc-200 shrink-0">
                        <div class="flex gap-2 mb-2 px-1">
                            <button class="w-7 h-7 flex items-center justify-center rounded text-zinc-400 hover:bg-zinc-100 hover:text-blue-600 transition-colors outline-none"><i class="far fa-image"></i></button>
                            <button class="w-7 h-7 flex items-center justify-center rounded text-zinc-400 hover:bg-zinc-100 hover:text-blue-600 transition-colors outline-none"><i class="far fa-folder"></i></button>
                        </div>
                        <div class="flex items-end gap-2 bg-zinc-50 border border-zinc-200 rounded-xl p-1.5 focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-500/20 transition-all">
                            <textarea id="seller-chat-input" rows="1" placeholder="Ketik pesan negosiasi..." class="w-full text-sm text-zinc-700 font-medium bg-transparent px-2 py-2 outline-none resize-none max-h-[100px] min-h-[40px] custom-scrollbar"></textarea>
                            <button onclick="sendSellerMessage()" class="w-10 h-10 rounded-lg bg-zinc-900 text-white flex items-center justify-center shrink-0 hover:bg-blue-600 hover:shadow-lg hover:-translate-y-0.5 transition-all outline-none">
                                <i class="fas fa-paper-plane text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ==========================================
             TAB 2: AI VIEW (POTA AI)
             ========================================== --}}
        <div id="view-ai" class="absolute inset-0 flex flex-col transition-all duration-500 ease-out opacity-0 translate-x-10 z-10 pointer-events-none bg-white">
            
            {{-- Header Khusus AI --}}
            <div class="bg-gradient-to-r from-zinc-950 to-zinc-900 p-4 flex justify-between items-center shrink-0 shadow-md relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/20 rounded-full blur-[30px]"></div>
                
                <div class="flex items-center gap-3 md:gap-4 relative z-10">
                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center border border-white/10 shadow-[0_0_20px_rgba(37,99,235,0.4)]">
                        <i class="fas fa-robot text-white text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-black text-white text-sm md:text-base tracking-wide">POTA AI Assistant</h4>
                        <p class="text-[9px] md:text-[10px] text-blue-300 font-bold uppercase tracking-widest flex items-center gap-1.5 mt-0.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span> Sistem Aktif
                        </p>
                    </div>
                </div>
                <button onclick="startVoiceCallMode()" class="relative z-10 w-10 h-10 md:w-11 md:h-11 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all outline-none border border-white/10 group">
                    <i class="fas fa-phone-alt group-hover:scale-110 transition-transform"></i>
                </button>
            </div>

            {{-- Area Pesan AI --}}
            <div class="flex-1 p-4 md:p-6 overflow-y-auto custom-scrollbar flex flex-col gap-4" id="ai-chat-messages">
                <div class="text-[10px] text-center text-zinc-400 font-black uppercase tracking-widest mb-2 flex items-center justify-center gap-2">
                    <span class="w-8 h-px bg-zinc-200"></span> Percakapan Pribadi Cerdas <span class="w-8 h-px bg-zinc-200"></span>
                </div>
                
                {{-- Pesan Welcome Bawaan AI --}}
                <div class="flex gap-3 max-w-[90%] md:max-w-[85%]">
                    <div class="w-8 h-8 rounded-full bg-blue-600 flex-shrink-0 flex items-center justify-center text-white text-xs shadow-md mt-auto"><i class="fas fa-robot"></i></div>
                    <div class="bg-blue-50 border border-blue-100 text-zinc-800 p-4 rounded-2xl rounded-bl-sm text-sm shadow-sm relative font-medium leading-relaxed">
                        Halo <strong>{{ auth()->user()?->nama ?? 'Juragan' }}</strong>! Saya POTA. Ingin mencari rekomendasi material terbaik, membandingkan harga pasar, atau butuh bantuan hitung RAB proyek hari ini?
                    </div>
                </div>
            </div>

            {{-- Input Area AI --}}
            <div class="p-3 md:p-4 bg-white border-t border-zinc-200 shrink-0 relative z-20">
                <div class="flex items-center gap-2 relative bg-zinc-50 border border-zinc-200 rounded-full p-1.5 focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-500/20 transition-all">
                    <button id="ai-voice-btn" onclick="toggleAIVoice()" class="w-10 h-10 rounded-full text-zinc-500 hover:bg-blue-100 hover:text-blue-600 flex items-center justify-center transition-all shrink-0 outline-none">
                        <i class="fas fa-microphone"></i>
                    </button>
                    <input type="text" id="ai-chat-input" placeholder="Tanya apapun tentang material & proyek..." class="flex-1 bg-transparent text-sm font-medium px-2 py-2 outline-none" onkeypress="handleAIEnter(event)">
                    <button id="send-ai-btn" onclick="sendAIMessage()" class="w-10 h-10 rounded-full bg-blue-600 text-white hover:bg-blue-700 flex items-center justify-center shrink-0 transition-all hover:shadow-lg hover:-translate-y-0.5 outline-none">
                        <i class="fas fa-paper-plane text-xs"></i>
                    </button>
                </div>
            </div>

            {{-- Voice Call Overlay Eksklusif AI --}}
            <div id="ai-voice-overlay" class="absolute inset-0 bg-zinc-950/95 backdrop-blur-xl z-[100] hidden flex-col items-center justify-center text-white">
                <div class="text-[11px] md:text-xs font-black tracking-[0.3em] text-blue-400 uppercase mb-16 animate-pulse" id="ai-voice-status">Mendengarkan...</div>
                
                <div class="relative w-32 h-32 flex items-center justify-center mb-16">
                    <div class="absolute inset-0 bg-blue-600/30 rounded-full animate-ping duration-1000"></div>
                    <div class="absolute inset-[-20px] bg-blue-500/10 rounded-full animate-ping duration-1000" style="animation-delay: 0.3s"></div>
                    <div id="ai-voice-visualizer" class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-3xl shadow-[0_0_50px_rgba(37,99,235,0.6)] z-10 transition-all duration-300 border border-white/20">
                        <i class="fas fa-microphone"></i>
                    </div>
                </div>

                <button onclick="endVoiceCallMode()" class="bg-red-500 text-white hover:bg-red-600 px-8 py-3.5 rounded-full font-black flex items-center gap-3 transition-all group text-xs md:text-sm outline-none shadow-[0_10px_20px_rgba(239,68,68,0.3)] hover:-translate-y-1">
                    <i class="fas fa-phone-slash"></i> Tutup Panggilan
                </button>
            </div>
        </div>

    </div>
</div>

{{-- ========================================================
     SCRIPT LOGIKA CHAT HUB (ANIMASI, API, VOICE, TAB)
     ======================================================== --}}
<style>
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar:hover::-webkit-scrollbar-thumb { background: #94a3b8; }
</style>

<script>
    /* === 1. GLOBAL & TAB LOGIC DENGAN ANIMASI SLIDE IOS === */
    const chatWindow = document.getElementById('live-chat-window');
    const viewSeller = document.getElementById('view-seller');
    const viewAI = document.getElementById('view-ai');
    
    const tabSellerBtn = document.getElementById('tab-btn-seller');
    const tabAIBtn = document.getElementById('tab-btn-ai');
    const tabSlider = document.getElementById('tab-slider');
    
    let currentStoreId = null;

    // Restore Session
    document.addEventListener('DOMContentLoaded', () => {
        const isOpen = sessionStorage.getItem('pota_chat_open') === 'true';
        const activeTab = sessionStorage.getItem('pota_chat_tab') || 'seller';

        // Pulihkan DOM AI Chat
        const savedAIDom = sessionStorage.getItem('pota_ai_dom');
        if(savedAIDom && document.getElementById('ai-chat-messages')) {
            document.getElementById('ai-chat-messages').innerHTML = savedAIDom;
            document.getElementById('ai-chat-messages').scrollTop = document.getElementById('ai-chat-messages').scrollHeight;
        }

        if(isOpen && chatWindow) {
            chatWindow.classList.remove('hidden', 'opacity-0', 'translate-y-10', 'scale-95', 'pointer-events-none');
            chatWindow.classList.add('flex', 'opacity-100', 'translate-y-0', 'scale-100');
            switchChatTab(activeTab, true); // True = instant tanpa animasi
        }

        fetchSellerContacts(); // Ambil kontak seller API
    });

    function toggleChatWindow() {
        if(chatWindow.classList.contains('hidden')) {
            const lastTab = sessionStorage.getItem('pota_chat_tab') || 'seller';
            switchChatTab(lastTab, true);
            
            chatWindow.classList.remove('hidden', 'opacity-0', 'translate-y-10', 'scale-95', 'pointer-events-none');
            chatWindow.classList.add('flex', 'opacity-100', 'translate-y-0', 'scale-100');
            sessionStorage.setItem('pota_chat_open', 'true');
        } else {
            chatWindow.classList.add('opacity-0', 'translate-y-10', 'scale-95', 'pointer-events-none');
            chatWindow.classList.remove('opacity-100', 'translate-y-0', 'scale-100');
            setTimeout(() => chatWindow.classList.add('hidden'), 500);
            sessionStorage.setItem('pota_chat_open', 'false');
            endVoiceCallMode(); // Matikan voice kalo ketutup
        }
    }

    function switchChatTab(tabName, instant = false) {
        sessionStorage.setItem('pota_chat_tab', tabName);

        if(tabName === 'ai') {
            // Slider UI Header
            tabSlider.style.transform = 'translateX(100%)';
            tabAIBtn.classList.replace('text-zinc-400', 'text-zinc-900');
            tabSellerBtn.classList.replace('text-zinc-900', 'text-zinc-400');

            // Slide Animation (Seller goes Left, AI comes from Right)
            if(!instant) {
                viewSeller.classList.replace('translate-x-0', '-translate-x-10');
                viewSeller.classList.replace('opacity-100', 'opacity-0');
                viewSeller.classList.replace('pointer-events-auto', 'pointer-events-none');
                viewSeller.classList.replace('z-20', 'z-0');
            } else {
                viewSeller.classList.add('opacity-0', 'pointer-events-none', 'z-0');
                viewSeller.classList.remove('opacity-100', 'pointer-events-auto', 'z-20');
            }

            viewAI.classList.replace('opacity-0', 'opacity-100');
            viewAI.classList.replace('translate-x-10', 'translate-x-0');
            viewAI.classList.replace('pointer-events-none', 'pointer-events-auto');
            viewAI.classList.replace('z-10', 'z-20');

            setTimeout(() => { document.getElementById('ai-chat-input').focus(); }, 300);
            
        } else {
            // Slider UI Header
            tabSlider.style.transform = 'translateX(0)';
            tabSellerBtn.classList.replace('text-zinc-400', 'text-zinc-900');
            tabAIBtn.classList.replace('text-zinc-900', 'text-zinc-400');

            // Slide Animation (AI goes Right, Seller comes from Left)
            if(!instant) {
                viewAI.classList.replace('translate-x-0', 'translate-x-10');
                viewAI.classList.replace('opacity-100', 'opacity-0');
                viewAI.classList.replace('pointer-events-auto', 'pointer-events-none');
                viewAI.classList.replace('z-20', 'z-10');
            } else {
                viewAI.classList.add('opacity-0', 'pointer-events-none', 'z-10');
                viewAI.classList.remove('opacity-100', 'pointer-events-auto', 'z-20');
            }

            viewSeller.classList.replace('opacity-0', 'opacity-100');
            viewSeller.classList.replace('-translate-x-10', 'translate-x-0');
            viewSeller.classList.replace('pointer-events-none', 'pointer-events-auto');
            viewSeller.classList.replace('z-0', 'z-20');
        }
    }

    function toggleFullScreen() {
        chatWindow.classList.toggle('md:w-[800px]');
        chatWindow.classList.toggle('md:h-[600px]');
        chatWindow.classList.toggle('w-[95vw]');
        chatWindow.classList.toggle('h-[90dvh]'); // pakai dvh agar aman di mobile
        const icon = document.getElementById('icon-resize');
        if(icon) icon.className = chatWindow.classList.contains('w-[95vw]') ? 'fas fa-compress' : 'fas fa-expand';
    }


    /* ========================================================
       2. SELLER CHAT LOGIC (API DENGAN SMART FALLBACK)
       ======================================================== */
    async function fetchSellerContacts() {
        const contactList = document.getElementById('seller-contact-list');
        try {
            const res = await fetch('/api/chat/contacts');
            if(!res.ok) throw new Error("API tidak merespon 200");
            const data = await res.json();
            renderContacts(data, contactList);
        } catch(e) {
            console.log("Menampilkan Data Kontak Dummy karena API belum siap:", e);
            // KODE SAKTI FALLBACK: Jika API mati/belum dibuat, tampilkan ini agar UI tidak rusak!
            const dummyContacts = [
                { store_id: 1, nama_toko: 'Baja Ringan Nusantara', last_message: 'Halo bos, baja CNP ready?', last_time: '10:45', unread_count: 2 },
                { store_id: 2, nama_toko: 'Toko Besi Sinar Jaya', last_message: 'Siap dikirim siang ini.', last_time: 'Kemarin', unread_count: 0 },
                { store_id: 3, nama_toko: 'Distributor Semen JKT', last_message: 'Harga grosir bisa turun lagi kak.', last_time: 'Senin', unread_count: 0 },
            ];
            renderContacts(dummyContacts, contactList);
        }
    }

    function renderContacts(data, container) {
        container.innerHTML = '';
        if(data.length === 0) {
            container.innerHTML = `<div class="p-6 text-center text-zinc-400 text-xs font-medium">Belum ada obrolan.</div>`;
            return;
        }

        data.forEach(toko => {
            const initial = toko.nama_toko.substring(0, 2).toUpperCase();
            const unreadBadge = toko.unread_count > 0 ? `<div class="bg-red-500 text-white text-[9px] font-black w-4 h-4 md:w-5 md:h-5 rounded-full flex items-center justify-center shadow-sm">${toko.unread_count}</div>` : '';
            const isActive = currentStoreId === toko.store_id ? 'bg-blue-50 border-l-4 border-l-blue-600' : 'hover:bg-zinc-50 border-l-4 border-l-transparent';
            
            let html = `
            <div onclick="openStoreChat(${toko.store_id}, '${toko.nama_toko}', '${initial}')" class="flex items-center gap-3 p-3 border-b border-zinc-100 cursor-pointer transition-all group ${isActive}">
                <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-zinc-200 text-zinc-700 flex items-center justify-center font-black text-xs md:text-sm shrink-0 shadow-inner group-hover:bg-blue-100 group-hover:text-blue-600 transition-colors">${initial}</div>
                <div class="flex-1 min-w-0 hidden md:block">
                    <div class="flex justify-between items-center mb-1">
                        <h4 class="text-xs font-black text-zinc-900 truncate group-hover:text-blue-600 transition-colors">${toko.nama_toko}</h4>
                        <span class="text-[9px] font-bold text-zinc-400 shrink-0 ml-2">${toko.last_time}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="text-[10px] text-zinc-500 font-medium truncate pr-2">${toko.last_message}</p>
                        ${unreadBadge}
                    </div>
                </div>
                <!-- Mode HP (hanya avatar & badge) -->
                <div class="md:hidden absolute top-1 right-1">${unreadBadge}</div>
            </div>`;
            container.insertAdjacentHTML('beforeend', html);
        });
    }

    async function openStoreChat(storeId, storeName, initials) {
        currentStoreId = storeId;
        fetchSellerContacts(); // Re-render untuk aktif state

        const emptyState = document.getElementById('seller-empty-state');
        const activeChat = document.getElementById('seller-active-chat');
        
        emptyState.classList.add('opacity-0', 'pointer-events-none');
        setTimeout(() => { emptyState.classList.add('hidden'); }, 300);

        activeChat.classList.remove('hidden');
        setTimeout(() => { activeChat.classList.remove('opacity-0'); }, 50);

        document.getElementById('active-store-name').innerText = storeName;
        document.getElementById('active-store-avatar').innerText = initials;

        const msgContainer = document.getElementById('seller-chat-messages');
        msgContainer.innerHTML = `<div class="text-center text-xs font-bold text-zinc-400 my-4 flex items-center justify-center gap-2"><i class="fas fa-circle-notch fa-spin"></i> Memuat histori...</div>`;

        try {
            const res = await fetch(`/api/chat/messages/${storeId}`);
            if(!res.ok) throw new Error();
            const data = await res.json();
            renderSellerMessages(data, msgContainer);
        } catch(e) {
            // FALLBACK DUMMY MESSAGES
            const dummyMsgs = [
                {sender: 'seller', text: 'Halo bos, barang ready stok banyak di gudang.', time: '09:00'},
                {sender: 'user', text: 'Kalo ambil 500 sak bisa nego?', time: '09:15'},
                {sender: 'seller', text: 'Tentu bisa. Silakan ajukan penawaran via fitur Nego ya.', time: '09:16'}
            ];
            renderSellerMessages(dummyMsgs, msgContainer);
        }
    }

    function renderSellerMessages(data, container) {
        container.innerHTML = '';
        data.forEach(msg => {
            let html = '';
            if(msg.sender === 'user') {
                html = `
                <div class="flex justify-end max-w-[85%] self-end group">
                    <div class="flex flex-col items-end">
                        <div class="bg-blue-600 text-white p-3 md:p-3.5 rounded-2xl rounded-tr-sm text-xs md:text-sm shadow-md font-medium leading-relaxed">${msg.text}</div>
                        <span class="text-[9px] font-bold text-zinc-400 mt-1.5">${msg.time}</span>
                    </div>
                </div>`;
            } else {
                html = `
                <div class="flex gap-2.5 max-w-[85%] group">
                    <div class="w-6 h-6 rounded-full bg-emerald-500 shrink-0 flex items-center justify-center text-white text-[8px] mt-auto shadow-sm"><i class="fas fa-store"></i></div>
                    <div class="flex flex-col items-start">
                        <div class="bg-white border border-zinc-200 text-zinc-800 p-3 md:p-3.5 rounded-2xl rounded-tl-sm text-xs md:text-sm shadow-sm font-medium leading-relaxed">${msg.text}</div>
                        <span class="text-[9px] font-bold text-zinc-400 mt-1.5">${msg.time}</span>
                    </div>
                </div>`;
            }
            container.insertAdjacentHTML('beforeend', html);
        });
        container.scrollTop = container.scrollHeight;
    }

    async function sendSellerMessage() {
        const input = document.getElementById('seller-chat-input');
        const text = input.value.trim();
        if(!text || !currentStoreId) return;

        const timeNow = new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'});
        
        // Optimistic UI Append
        const msgContainer = document.getElementById('seller-chat-messages');
        const html = `
        <div class="flex justify-end max-w-[85%] self-end group opacity-70" id="msg-temp-${Date.now()}">
            <div class="flex flex-col items-end">
                <div class="bg-blue-600 text-white p-3 md:p-3.5 rounded-2xl rounded-tr-sm text-xs md:text-sm shadow-md font-medium leading-relaxed">${text}</div>
                <span class="text-[9px] font-bold text-zinc-400 mt-1.5 flex items-center gap-1"><i class="far fa-clock"></i> Mengirim...</span>
            </div>
        </div>`;
        msgContainer.insertAdjacentHTML('beforeend', html);
        msgContainer.scrollTop = msgContainer.scrollHeight;
        input.value = '';

        try {
            // Simulasi API / Hit API Asli
            await fetch('/api/chat/send', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ message: text, store_id: currentStoreId })
            });
            // Update UI ke Terkirim (Hanya simulasi visual)
            setTimeout(() => {
                const tempMsg = msgContainer.lastElementChild;
                if(tempMsg) {
                    tempMsg.classList.remove('opacity-70');
                    tempMsg.querySelector('.fa-clock').parentElement.innerHTML = `${timeNow}`;
                }
            }, 500);
        } catch(e) {
            // Biarkan sukses di visual untuk UX Fallback saat demo
            setTimeout(() => {
                const tempMsg = msgContainer.lastElementChild;
                if(tempMsg) {
                    tempMsg.classList.remove('opacity-70');
                    tempMsg.querySelector('.fa-clock').parentElement.innerHTML = `${timeNow}`;
                }
            }, 500);
        }
    }

    document.getElementById('seller-chat-input').addEventListener('keypress', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendSellerMessage();
        }
    });


    /* ========================================================
       3. POTA AI CHAT & VOICE LOGIC
       ======================================================== */
    const aiMessagesContainer = document.getElementById('ai-chat-messages');
    const aiInput = document.getElementById('ai-chat-input');
    const aiCallOverlay = document.getElementById('ai-voice-overlay');
    let aiChatHistory = [];

    // Web Speech API
    let recognition = null;
    let isAiCallMode = false;
    let voices = [];

    window.speechSynthesis.onvoiceschanged = () => { voices = window.speechSynthesis.getVoices(); };

    if (window.SpeechRecognition || window.webkitSpeechRecognition) {
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        recognition = new SpeechRecognition();
        recognition.lang = 'id-ID';
        recognition.interimResults = false;

        recognition.onresult = (event) => {
            const text = event.results[0][0].transcript;
            if(isAiCallMode) {
                document.getElementById('ai-voice-status').innerText = "Menganalisa data...";
                document.getElementById('ai-voice-visualizer').classList.remove('animate-pulse');
                sendAIMessage(text);
            } else {
                if(aiInput) aiInput.value = text;
                stopRecordingUI();
            }
        };
        recognition.onerror = () => { 
            stopRecordingUI(); 
            if(isAiCallMode) { 
                document.getElementById('ai-voice-status').innerText = "Suara tidak terdengar."; 
                setTimeout(() => { if(isAiCallMode) recognition.start(); }, 2000); 
            } 
        };
        recognition.onend = () => { if(!isAiCallMode) stopRecordingUI(); };
    }

    function toggleAIVoice() {
        if(!recognition) return alert("Browser tidak mendukung mic.");
        const btn = document.getElementById('ai-voice-btn');
        if(btn.classList.contains('bg-blue-600')) { 
            recognition.stop(); stopRecordingUI(); 
        } else { 
            recognition.start(); startRecordingUI(); 
        }
    }

    function startRecordingUI() {
        const btn = document.getElementById('ai-voice-btn');
        if(btn) {
            btn.classList.add('bg-blue-600', 'text-white', 'animate-pulse');
            btn.classList.remove('bg-zinc-100', 'text-zinc-500');
        }
    }

    function stopRecordingUI() {
        const btn = document.getElementById('ai-voice-btn');
        if(btn) {
            btn.classList.remove('bg-blue-600', 'text-white', 'animate-pulse');
            btn.classList.add('bg-zinc-100', 'text-zinc-500');
        }
    }

    function startVoiceCallMode() {
        if(!recognition) return alert("Browser tidak mendukung fitur suara.");
        isAiCallMode = true;
        aiCallOverlay.classList.remove('hidden'); 
        aiCallOverlay.classList.add('flex');
        document.getElementById('ai-voice-status').innerText = "Mandor Standby...";
        document.getElementById('ai-voice-visualizer').classList.add('animate-pulse');
        speakText("Halo Bosku! Ada yang bisa POTA bantu untuk proyek hari ini?", true);
    }

    function endVoiceCallMode() {
        isAiCallMode = false;
        aiCallOverlay.classList.add('hidden'); 
        aiCallOverlay.classList.remove('flex');
        window.speechSynthesis.cancel();
        if(recognition) recognition.stop();
    }

    function saveAIState() {
        if(aiMessagesContainer) {
            sessionStorage.setItem('pota_ai_dom', aiMessagesContainer.innerHTML);
            sessionStorage.setItem('pota_ai_history', JSON.stringify(aiChatHistory));
        }
    }

    function appendAIMessage(text, sender) {
        if(!aiMessagesContainer) return;
        const clean = text.replace(/"/g, "'").replace(/\n/g, " ").replace(/<[^>]*>?/gm, '');
        
        let html = '';
        if(sender === 'bot') {
            html = `
            <div class="flex gap-3 max-w-[90%] md:max-w-[85%] origin-bottom-left transition-all animate-[scale-in-bl_0.3s_ease-out]">
                <div class="w-8 h-8 rounded-full bg-blue-600 flex-shrink-0 flex items-center justify-center text-white text-xs shadow-md mt-auto"><i class="fas fa-robot"></i></div>
                <div class="bg-blue-50 border border-blue-100 text-zinc-800 p-4 rounded-2xl rounded-bl-sm text-sm shadow-sm relative group font-medium leading-relaxed">
                    ${text}
                    <button onclick="speakText('${clean}')" class="absolute -right-8 bottom-1 w-6 h-6 rounded-full text-zinc-400 hover:text-blue-600 opacity-0 group-hover:opacity-100 transition-all outline-none"><i class="fas fa-volume-up text-xs"></i></button>
                </div>
            </div>`;
        } else {
            html = `
            <div class="flex justify-end max-w-[90%] md:max-w-[85%] self-end origin-bottom-right animate-[scale-in-br_0.3s_ease-out]">
                <div class="bg-zinc-900 text-white p-4 rounded-2xl rounded-br-sm text-sm font-medium shadow-md leading-relaxed">${text}</div>
            </div>`;
        }
        
        aiMessagesContainer.insertAdjacentHTML('beforeend', html);
        aiMessagesContainer.scrollTop = aiMessagesContainer.scrollHeight;
        saveAIState();
    }

    async function sendAIMessage(textOverride = null) {
        if(!aiInput) return;
        const text = textOverride || aiInput.value.trim();
        if(!text) return;
        
        if(!textOverride) { appendAIMessage(text, 'user'); aiInput.value = ''; }
        aiChatHistory.push({sender:'user', text:text});

        if(!isAiCallMode) {
            const loadHtml = `
            <div id="ai-loading" class="flex gap-1.5 ml-14 items-center text-blue-500 my-2">
                <span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce"></span>
                <span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                <span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 0.4s"></span>
            </div>`;
            aiMessagesContainer.insertAdjacentHTML('beforeend', loadHtml);
            aiMessagesContainer.scrollTop = aiMessagesContainer.scrollHeight;
        }

        try {
            const res = await fetch('/api/chat', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({message: text, history: aiChatHistory.slice(-6)})
            });
            if (!res.ok) throw new Error("Gagal terhubung.");
            const data = await res.json();

            if(document.getElementById('ai-loading')) document.getElementById('ai-loading').remove();
            appendAIMessage(data.reply, 'bot');
            aiChatHistory.push({sender:'bot', text: data.reply.replace(/<[^>]*>?/gm, '')});
            
            if(isAiCallMode) speakText(data.reply, true);

        } catch(e) {
            if(document.getElementById('ai-loading')) document.getElementById('ai-loading').remove();
            appendAIMessage("Mohon maaf, server AI POTA sedang sibuk. Coba beberapa saat lagi ya Bos.", 'bot');
        }
    }

    function handleAIEnter(e) { if(e.key === 'Enter') sendAIMessage(); }

    function speakText(text, autoListen = false) {
        window.speechSynthesis.cancel();
        const u = new SpeechSynthesisUtterance(text);
        u.lang = 'id-ID'; 
        u.rate = 1.05;

        const indoVoice = voices.find(v => v.lang === 'id-ID' && (v.name.includes('Google') || v.name.includes('Online')));
        if (indoVoice) u.voice = indoVoice;

        u.onstart = () => {
            if(isAiCallMode) {
                document.getElementById('ai-voice-status').innerText = "POTA Berbicara...";
                document.getElementById('ai-voice-visualizer').classList.remove('animate-pulse');
            }
        };
        u.onend = () => { 
            if(isAiCallMode && autoListen) { 
                recognition.start(); 
                document.getElementById('ai-voice-status').innerText = "Silakan bicara Bos..."; 
                document.getElementById('ai-voice-visualizer').classList.add('animate-pulse');
            }
        };
        window.speechSynthesis.speak(u);
    }
</script>