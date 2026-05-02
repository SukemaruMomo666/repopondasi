{{-- ===================== CHAT HUB (POTA AI & SELLER) ===================== --}}
<button id="live-chat-toggle" class="fixed bottom-4 right-4 md:bottom-6 md:right-6 bg-black text-white p-1 pr-4 md:pr-5 rounded-full shadow-[0_10px_30px_rgba(0,0,0,0.4)] hover:shadow-[0_15px_40px_rgba(37,99,235,0.4)] transition-all duration-300 z-[999] flex items-center gap-2 md:gap-3 group border border-zinc-800 hover:border-blue-500 overflow-hidden outline-none" onclick="toggleChatWindow()">
    <div class="bg-blue-600 w-10 h-10 md:w-12 md:h-12 rounded-full relative flex items-center justify-center">
        <div class="absolute inset-0 rounded-full animate-pulse-glow opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <i class="fas fa-comments text-lg md:text-xl relative z-10"></i>
    </div>
    <div class="flex flex-col text-left hidden sm:flex">
        <span class="font-black text-xs md:text-sm tracking-wide">Pusat Obrolan</span>
        <span class="text-[9px] md:text-[10px] text-zinc-400 font-bold uppercase tracking-widest">Tanya / Nego</span>
    </div>
</button>

{{-- Chat Window --}}
<div id="live-chat-window" class="fixed bottom-20 md:bottom-24 right-4 md:right-6 w-[calc(100vw-2rem)] sm:w-[360px] md:w-[380px] h-[75vh] md:h-[580px] bg-white rounded-3xl shadow-[0_30px_60px_rgba(0,0,0,0.15)] border border-zinc-200 flex flex-col overflow-hidden z-[999] transition-all duration-500 opacity-0 translate-y-10 scale-95 pointer-events-none hidden origin-bottom-right">

    {{-- Header (Black) --}}
    <div class="bg-black text-white p-4 md:p-5 flex justify-between items-center shrink-0 border-b border-zinc-800 z-10 relative">
        <div class="flex items-center gap-2.5 md:gap-3 flex-1">
            {{-- TAB SWITCHER ELEGAN --}}
            <div class="flex bg-zinc-900 rounded-xl p-1 border border-zinc-800 relative z-20 w-[160px] md:w-[180px]">
                <button onclick="openChatSeller()" id="tab-btn-seller" class="flex-1 relative z-10 px-2 py-1.5 md:py-2 text-[10px] md:text-xs font-black uppercase tracking-widest rounded-lg transition-colors outline-none text-emerald-400 bg-emerald-500/10">
                    <i class="fas fa-store mr-1"></i> Penjual
                </button>
                <button onclick="openChatAI()" id="tab-btn-ai" class="flex-1 relative z-10 px-2 py-1.5 md:py-2 text-[10px] md:text-xs font-black uppercase tracking-widest rounded-lg transition-colors outline-none text-zinc-500 hover:text-white">
                    <i class="fas fa-robot mr-1"></i> AI
                </button>
            </div>
        </div>

        <div class="flex items-center gap-0.5 md:gap-1">
            <button id="chat-call-btn" onclick="startVoiceCallMode()" class="hidden w-7 h-7 md:w-8 md:h-8 rounded-lg hover:bg-zinc-800 text-zinc-400 hover:text-blue-400 flex items-center justify-center transition-all outline-none"><i class="fas fa-phone text-xs md:text-sm"></i></button>
            <button onclick="toggleFullScreen()" class="w-7 h-7 md:w-8 md:h-8 rounded-lg hover:bg-zinc-800 text-zinc-400 hover:text-white items-center justify-center transition-all outline-none hidden sm:flex"><i id="icon-resize" class="fas fa-expand text-xs md:text-sm"></i></button>
            <button onclick="toggleChatWindow()" class="w-7 h-7 md:w-8 md:h-8 rounded-lg hover:bg-red-500/20 text-zinc-400 hover:text-red-500 flex items-center justify-center transition-all outline-none"><i class="fas fa-xmark text-sm md:text-base"></i></button>
        </div>
    </div>

    {{-- 1. SELLER VIEW (Default Tab) --}}
    <div id="chat-seller-view" class="flex flex-1 flex-col bg-zinc-50 relative overflow-hidden">
        {{-- Contact List --}}
        <div class="flex-1 overflow-y-auto p-4 space-y-2">
            <div class="text-[9px] font-black tracking-widest text-zinc-400 uppercase px-2 mb-3">Pesan Terbaru</div>

            <a href="#" class="flex items-center gap-3 p-3 bg-white rounded-2xl shadow-sm border border-zinc-100 hover:border-emerald-300 transition-colors group">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-black shadow-inner shrink-0">TB</div>
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-start mb-1">
                        <h4 class="text-xs font-black text-zinc-900 truncate group-hover:text-emerald-600">Toko Bangunan Jaya</h4>
                        <span class="text-[9px] font-bold text-zinc-400 shrink-0 ml-2">10:42</span>
                    </div>
                    <p class="text-[10px] text-zinc-500 truncate">Semen Tiga Roda ready bos, mau berapa sak?</p>
                </div>
            </a>

            <a href="#" class="flex items-center gap-3 p-3 bg-white rounded-2xl shadow-sm border border-zinc-100 hover:border-emerald-300 transition-colors group">
                <div class="w-12 h-12 rounded-xl bg-zinc-100 text-zinc-600 flex items-center justify-center font-black shadow-inner shrink-0">MA</div>
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-start mb-1">
                        <h4 class="text-xs font-black text-zinc-900 truncate group-hover:text-emerald-600">Mitra Abadi Baja</h4>
                        <span class="text-[9px] font-bold text-zinc-400 shrink-0 ml-2">Kemarin</span>
                    </div>
                    <p class="text-[10px] text-zinc-500 truncate">Bisa dikirim siang ini menggunakan engkel.</p>
                </div>
            </a>
        </div>

        <div class="p-4 bg-white border-t border-zinc-200 text-center shrink-0 z-10 relative">
             <p class="text-[10px] font-medium text-zinc-500 mb-3">Pilih toko dari direktori untuk memulai obrolan baru.</p>
             <a href="{{ url('pages/semua_toko') }}" class="w-full bg-zinc-900 text-white block py-2.5 rounded-xl text-xs font-bold hover:bg-emerald-500 transition-colors shadow-sm">
                 Cari Mitra Toko
             </a>
        </div>
    </div>

    {{-- 2. AI VIEW (POTA) --}}
    <div id="chat-ai-view" class="hidden flex-1 flex-col h-full overflow-hidden bg-white relative">
        <div class="flex-1 p-4 md:p-5 overflow-y-auto bg-zinc-50 flex flex-col gap-3 md:gap-4 chat-messages relative" id="chat-messages">
            <div class="text-[9px] md:text-[10px] text-center text-zinc-400 font-bold uppercase tracking-widest mb-1 md:mb-2">Hari ini</div>
            <div class="flex gap-2 max-w-[90%] sm:max-w-[85%]">
                <div class="w-6 h-6 md:w-8 md:h-8 rounded-lg md:rounded-xl bg-black flex-shrink-0 flex items-center justify-center text-white text-[10px] md:text-xs mt-auto"><i class="fas fa-robot text-blue-500"></i></div>
                <div class="bg-white border border-zinc-200 text-zinc-800 p-3 md:p-3.5 rounded-2xl rounded-bl-sm text-xs md:text-sm shadow-sm relative group font-medium leading-relaxed">
                    Sistem siap, {{ auth()->user()?->nama ?? 'Juragan' }}! Cari material baja, hitung semen, atau lacak pesanan B2B?
                </div>
            </div>
        </div>

        <div class="p-2.5 md:p-3 bg-white border-t border-zinc-200 flex items-center gap-2 shrink-0 relative z-20">
            <button id="voice-btn" onclick="toggleVoice()" class="w-9 h-9 md:w-10 md:h-10 rounded-xl bg-zinc-100 text-zinc-500 hover:bg-black hover:text-white flex items-center justify-center transition-all flex-shrink-0 outline-none">
                <i class="fas fa-microphone text-sm"></i>
            </button>
            <div class="flex-1 relative">
                <input type="text" id="chat-input" placeholder="Tanya POTA..." class="w-full bg-zinc-100 text-xs md:text-sm font-medium rounded-xl pl-3 md:pl-4 pr-10 py-2.5 md:py-3 outline-none focus:ring-1 focus:ring-black border border-transparent transition-all placeholder:text-zinc-400" onkeypress="handleEnter(event)">
                <button id="send-chat-btn" onclick="sendMessage()" class="absolute right-1 top-1/2 -translate-y-1/2 w-7 h-7 md:w-8 md:h-8 rounded-lg bg-black text-white hover:bg-blue-600 flex items-center justify-center transition-colors outline-none">
                    <i class="fas fa-arrow-up text-[10px] md:text-xs"></i>
                </button>
            </div>
        </div>

        {{-- Voice Call Overlay --}}
        <div id="voice-call-overlay" class="absolute inset-0 bg-black/95 backdrop-blur-md z-30 hidden flex-col items-center justify-center text-white">
            <div class="text-[10px] md:text-xs font-black tracking-widest text-zinc-500 uppercase mb-12 md:mb-16" id="voice-status-text">Menyambungkan...</div>
            <div class="relative w-24 h-24 md:w-32 md:h-32 flex items-center justify-center mb-12 md:mb-16">
                <div class="absolute inset-0 bg-blue-600/20 rounded-full animate-ping duration-1000"></div>
                <div id="voice-visualizer" class="w-20 h-20 md:w-24 md:h-24 rounded-full bg-blue-600 flex items-center justify-center text-white text-2xl md:text-3xl shadow-[0_0_30px_rgba(37,99,235,0.4)] z-10 transition-all duration-500">
                    <i class="fas fa-microphone"></i>
                </div>
            </div>
            <button onclick="endVoiceCallMode()" class="bg-zinc-900 border border-zinc-800 text-white hover:text-red-500 hover:border-red-500 px-6 py-2.5 md:px-8 md:py-3 rounded-full font-bold flex items-center gap-2 transition-all group text-xs md:text-sm outline-none z-40 relative">
                <i class="fas fa-phone-slash group-hover:animate-bounce"></i> Tutup Panggilan
            </button>
        </div>
    </div>
</div>

<script>
    /* === GLOBAL CHAT HUB LOGIC DENGAN SESSION STORAGE === */
    const chatWindow = document.getElementById('live-chat-window');
    const aiView = document.getElementById('chat-ai-view');
    const sellerView = document.getElementById('chat-seller-view');
    const callBtn = document.getElementById('chat-call-btn');
    const tabBtnSeller = document.getElementById('tab-btn-seller');
    const tabBtnAI = document.getElementById('tab-btn-ai');
    const messagesContainer = document.getElementById('chat-messages');

    // Restore chat state di SEMUA halaman
    document.addEventListener('DOMContentLoaded', () => {
        const isOpen = sessionStorage.getItem('pota_chat_open') === 'true';
        const activeTab = sessionStorage.getItem('pota_chat_tab') || 'seller';
        const savedDOM = sessionStorage.getItem('pota_chat_dom');
        const savedHistory = sessionStorage.getItem('pota_chat_history');

        if(savedDOM && messagesContainer) {
            messagesContainer.innerHTML = savedDOM;
            if(savedHistory) chatHistory = JSON.parse(savedHistory);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        if(isOpen && chatWindow) {
            if(activeTab === 'ai') openChatAI(); else openChatSeller();
            chatWindow.classList.remove('hidden', 'opacity-0', 'translate-y-10', 'scale-95', 'pointer-events-none');
            chatWindow.classList.add('flex', 'opacity-100', 'translate-y-0', 'scale-100');
        }
    });

    function toggleChatWindow() {
        if(chatWindow.classList.contains('hidden')) {
            const lastTab = sessionStorage.getItem('pota_chat_tab') || 'seller';
            if(lastTab === 'ai') openChatAI(); else openChatSeller();

            chatWindow.classList.remove('hidden', 'opacity-0', 'translate-y-10', 'scale-95', 'pointer-events-none');
            chatWindow.classList.add('flex', 'opacity-100', 'translate-y-0', 'scale-100');
            sessionStorage.setItem('pota_chat_open', 'true');
        } else {
            chatWindow.classList.add('opacity-0', 'translate-y-10', 'scale-95', 'pointer-events-none');
            chatWindow.classList.remove('opacity-100', 'translate-y-0', 'scale-100');
            setTimeout(() => chatWindow.classList.add('hidden'), 500);
            endVoiceCallMode();
            sessionStorage.setItem('pota_chat_open', 'false');
        }
    }

    function openChatAI() {
        sessionStorage.setItem('pota_chat_tab', 'ai');
        if(sellerView) { sellerView.classList.add('hidden'); sellerView.classList.remove('flex'); }
        if(aiView) { aiView.classList.remove('hidden'); aiView.classList.add('flex'); }
        if(callBtn) { callBtn.classList.remove('hidden'); callBtn.classList.add('flex'); }

        if(tabBtnAI) tabBtnAI.className = "flex-1 relative z-10 px-2 py-1.5 md:py-2 text-[10px] md:text-xs font-black uppercase tracking-widest rounded-lg transition-colors outline-none text-blue-400 bg-blue-500/10";
        if(tabBtnSeller) tabBtnSeller.className = "flex-1 relative z-10 px-2 py-1.5 md:py-2 text-[10px] md:text-xs font-black uppercase tracking-widest rounded-lg transition-colors outline-none text-zinc-500 hover:text-white";

        setTimeout(() => {
            let input = document.getElementById('chat-input');
            if(input) input.focus();
        }, 100);
        setTimeout(() => { if(messagesContainer) messagesContainer.scrollTop = messagesContainer.scrollHeight; }, 50);
    }

    function openChatSeller() {
        sessionStorage.setItem('pota_chat_tab', 'seller');
        if(aiView) { aiView.classList.add('hidden'); aiView.classList.remove('flex'); }
        if(sellerView) { sellerView.classList.remove('hidden'); sellerView.classList.add('flex'); }
        if(callBtn) { callBtn.classList.remove('flex'); callBtn.classList.add('hidden'); }

        if(tabBtnSeller) tabBtnSeller.className = "flex-1 relative z-10 px-2 py-1.5 md:py-2 text-[10px] md:text-xs font-black uppercase tracking-widest rounded-lg transition-colors outline-none text-emerald-400 bg-emerald-500/10";
        if(tabBtnAI) tabBtnAI.className = "flex-1 relative z-10 px-2 py-1.5 md:py-2 text-[10px] md:text-xs font-black uppercase tracking-widest rounded-lg transition-colors outline-none text-zinc-500 hover:text-white";
    }

    function toggleFullScreen() {
        chatWindow.classList.toggle('sm:w-[360px]');
        chatWindow.classList.toggle('md:w-[380px]');
        chatWindow.classList.toggle('h-[75vh]');
        chatWindow.classList.toggle('md:h-[580px]');
        chatWindow.classList.toggle('w-[90vw]');
        chatWindow.classList.toggle('h-[85vh]');

        const icon = document.getElementById('icon-resize');
        if(icon) icon.className = chatWindow.classList.contains('w-[90vw]') ? 'fas fa-compress text-xs md:text-sm' : 'fas fa-expand text-xs md:text-sm';
    }

    /* === CHATBOT POTA LOGIC (Sama persis tidak ada yang hilang) === */
    const chatInput = document.getElementById('chat-input');
    const callOverlay = document.getElementById('voice-call-overlay');
    const voiceStatus = document.getElementById('voice-status-text');
    const voiceVisualizer = document.getElementById('voice-visualizer');
    const voiceBtn = document.getElementById('voice-btn');

    let chatHistory = [];
    let isCallMode = false;
    let recognition = null;
    let voices = [];

    function loadVoices() { voices = window.speechSynthesis.getVoices(); }
    window.speechSynthesis.onvoiceschanged = loadVoices;

    if (window.SpeechRecognition || window.webkitSpeechRecognition) {
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        recognition = new SpeechRecognition();
        recognition.lang = 'id-ID';
        recognition.interimResults = false;

        recognition.onresult = (event) => {
            const text = event.results[0][0].transcript;
            if(isCallMode) {
                voiceStatus.innerText = "Menganalisa...";
                voiceVisualizer.classList.remove('animate-pulse');
                sendMessage(text);
            } else {
                if(chatInput) chatInput.value = text;
                stopRecordingUI();
            }
        };
        recognition.onerror = (e) => { stopRecordingUI(); if(isCallMode) { voiceStatus.innerText = "Tidak terdengar."; setTimeout(startListening, 2000); } };
        recognition.onend = () => { if(!isCallMode) stopRecordingUI(); };
    }

    function handleEnter(e) { if(e.key === 'Enter') sendMessage(); }

    function toggleVoice() {
        if(!recognition) return alert("Browser tidak mendukung mic.");
        if(voiceBtn.classList.contains('text-white') && voiceBtn.classList.contains('bg-blue-600')) { recognition.stop(); stopRecordingUI(); }
        else { recognition.start(); startRecordingUI(); }
    }

    function startRecordingUI() {
        if(voiceBtn) {
            voiceBtn.classList.add('text-white', 'bg-blue-600', 'animate-pulse');
            voiceBtn.classList.remove('text-zinc-500', 'bg-zinc-100');
        }
    }

    function stopRecordingUI() {
        if(voiceBtn) {
            voiceBtn.classList.remove('text-white', 'bg-blue-600', 'animate-pulse');
            voiceBtn.classList.add('text-zinc-500', 'bg-zinc-100');
        }
    }

    function startVoiceCallMode() {
        if(!recognition) return alert("Browser tidak mendukung.");
        isCallMode = true;
        if(callOverlay) { callOverlay.classList.remove('hidden'); callOverlay.classList.add('flex'); }
        if(voiceStatus) voiceStatus.innerText = "Mandor Standby...";
        if(voiceVisualizer) voiceVisualizer.classList.add('animate-pulse');
        speakText("Halo! Ada proyek apa hari ini?", true);
    }

    function endVoiceCallMode() {
        isCallMode = false;
        if(callOverlay) { callOverlay.classList.add('hidden'); callOverlay.classList.remove('flex'); }
        window.speechSynthesis.cancel();
        if(recognition) recognition.stop();
    }

    function startListening() {
        if(!isCallMode) return;
        try {
            recognition.start();
            if(voiceStatus) voiceStatus.innerText = "Silakan bicara...";
            if(voiceVisualizer) voiceVisualizer.classList.add('animate-pulse');
        } catch(e) {}
    }

    function saveChatState() {
        if(messagesContainer) {
            sessionStorage.setItem('pota_chat_history', JSON.stringify(chatHistory));
            sessionStorage.setItem('pota_chat_dom', messagesContainer.innerHTML);
        }
    }

    function appendMessage(text, sender) {
        if(!messagesContainer) return;
        const div = document.createElement('div');
        if(sender === 'bot') {
            div.className = "flex gap-2 max-w-[90%] sm:max-w-[85%] origin-bottom-left animate-[scale-in-bl_0.3s_both]";
            const clean = text.replace(/"/g, "'").replace(/\n/g, " ").replace(/<[^>]*>?/gm, '');
            div.innerHTML = `
                <div class="w-6 h-6 md:w-8 md:h-8 rounded-lg md:rounded-xl bg-black flex-shrink-0 flex items-center justify-center text-white text-[10px] md:text-xs mt-auto"><i class="fas fa-robot text-blue-500"></i></div>
                <div class="bg-white border border-zinc-200 text-zinc-800 p-3 md:p-3.5 rounded-2xl rounded-bl-sm text-xs md:text-sm shadow-sm relative group font-medium leading-relaxed">
                    ${text}
                    <button onclick="speakText('${clean}')" class="absolute -right-6 md:-right-8 bottom-1 w-5 h-5 md:w-6 md:h-6 rounded-full text-zinc-400 hover:text-blue-500 opacity-0 group-hover:opacity-100 transition-all outline-none"><i class="fas fa-volume-up text-[10px] md:text-xs"></i></button>
                </div>`;
        } else {
            div.className = "flex max-w-[90%] sm:max-w-[85%] self-end origin-bottom-right animate-[scale-in-br_0.3s_both]";
            div.innerHTML = `<div class="bg-black text-white p-3 md:p-3.5 rounded-2xl rounded-br-sm text-xs md:text-sm font-medium shadow-md border border-zinc-800">${text}</div>`;
        }
        messagesContainer.appendChild(div);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
        saveChatState();
    }

    async function sendMessage(textOverride = null) {
        if(!chatInput) return;
        const text = textOverride || chatInput.value.trim();
        if(!text) return;
        if(!textOverride) { appendMessage(text, 'user'); chatInput.value = ''; }
        chatHistory.push({sender:'user', text:text});

        if(!isCallMode && messagesContainer) {
            const loadDiv = document.createElement('div');
            loadDiv.id = 'loading';
            loadDiv.className = 'flex gap-1.5 ml-8 md:ml-10 items-center text-blue-500 mt-2 mb-4';
            loadDiv.innerHTML = '<span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce"></span><span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></span><span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 0.4s"></span>';
            messagesContainer.appendChild(loadDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        try {
            const res = await fetch('/api/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({message: text, history: chatHistory.slice(-6)})
            });

            if (!res.ok) {
                const errorData = await res.json();
                throw new Error(errorData.reply || "Gagal terhubung ke otak POTA.");
            }

            const data = await res.json();

            if(!isCallMode && document.getElementById('loading')) document.getElementById('loading').remove();
            appendMessage(data.reply, 'bot');
            chatHistory.push({sender:'bot', text: data.reply.replace(/<[^>]*>?/gm, '')});
            if(isCallMode) speakText(data.reply, true);

        } catch(e) {
            if(document.getElementById('loading')) document.getElementById('loading').remove();
            console.error("ERROR POTA:", e);
            appendMessage("⚠️ " + e.message, 'bot');
        }
    }

    function speakText(text, autoListen = false) {
        window.speechSynthesis.cancel();
        const u = new SpeechSynthesisUtterance(text.replace(/<[^>]*>?/gm, '').replace(/[*_#]/g, ''));
        u.lang = 'id-ID'; u.pitch = 0.9; u.rate = 1.0;

        const indoVoice = voices.find(v => v.lang === 'id-ID' && v.name.includes('Google'));
        if (indoVoice) u.voice = indoVoice;

        u.onstart = () => {
            if(isCallMode) {
                if(voiceVisualizer) voiceVisualizer.classList.remove('animate-pulse');
                if(voiceStatus) voiceStatus.innerText = "Mandor Menjawab...";
            }
        };
        u.onend = () => { if(isCallMode && autoListen) setTimeout(startListening, 500); };
        window.speechSynthesis.speak(u);
    }

    // CSS Animation for chat bubbles
    const style = document.createElement('style');
    style.innerHTML = `
        @keyframes scale-in-bl { 0% { transform: scale(0); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
        @keyframes scale-in-br { 0% { transform: scale(0); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
    `;
    document.head.appendChild(style);
</script>
