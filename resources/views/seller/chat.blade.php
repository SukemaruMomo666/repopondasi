@extends('layouts.seller')

@section('title', 'Pusat Pesan (Chat)')

@push('styles')
<style>
    /* Styling khusus scrollbar Chat */
    .chat-scrollbar::-webkit-scrollbar { width: 6px; }
    .chat-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .chat-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .chat-scrollbar:hover::-webkit-scrollbar-thumb { background: #94a3b8; }

    /* Styling Custom Audio Player */
    .custom-audio { height: 35px; border-radius: 20px; outline: none; }
    .custom-audio::-webkit-media-controls-panel { background-color: #f8fafc; }
</style>
@endpush

@section('content')
<div class="h-[calc(100vh-100px)] bg-slate-50 p-4 md:p-6 lg:p-8 font-sans text-slate-900 flex flex-col">

    {{-- HEADER PAGE --}}
    <div class="flex items-center gap-4 mb-6 flex-shrink-0">
        <div class="w-12 h-12 bg-white border border-slate-200 rounded-2xl flex items-center justify-center text-blue-600 shadow-sm flex-shrink-0">
            <i class="mdi mdi-forum-outline text-2xl"></i>
        </div>
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Pusat Pesan Pelanggan</h1>
            <p class="text-sm font-medium text-slate-500 mt-0.5">Jawab pertanyaan pembeli dengan cepat untuk meningkatkan rasio penjualan.</p>
        </div>
    </div>

    {{-- CHAT ENGINE CONTAINER --}}
    <div class="flex flex-1 bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm relative">

        {{-- ================================================= --}}
        {{-- SISI KIRI: DAFTAR KONTAK (SIDEBAR)                --}}
        {{-- ================================================= --}}
        <div id="sidebarPanel" class="w-full md:w-[320px] lg:w-[380px] bg-slate-50 border-r border-slate-200 flex flex-col flex-shrink-0 transition-transform duration-300 relative z-10">

            {{-- Header & Search --}}
            <div class="p-4 border-b border-slate-200 bg-white">
                <div class="relative w-full group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="mdi mdi-magnify text-slate-400 group-focus-within:text-blue-600 transition-colors text-lg"></i>
                    </div>
                    <input type="text" id="searchContact" placeholder="Cari pelanggan..." class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:bg-white outline-none transition-all shadow-sm">
                </div>
            </div>

            {{-- Contact List --}}
            <div id="contactList" class="flex-1 overflow-y-auto chat-scrollbar bg-slate-50">
                <div class="flex flex-col items-center justify-center py-10 opacity-50">
                    <i class="mdi mdi-loading mdi-spin text-4xl text-slate-400 mb-3"></i>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Memuat Riwayat Chat...</p>
                </div>
            </div>

        </div>

        {{-- ================================================= --}}
        {{-- SISI KANAN: RUANG CHAT                            --}}
        {{-- ================================================= --}}
        <div id="chatPanel" class="absolute md:relative top-0 left-0 w-full h-full md:flex flex-1 flex-col bg-slate-100 z-20 md:z-auto transition-transform duration-300 translate-x-full md:translate-x-0 hidden md:block">

            {{-- EMPTY STATE: Belum pilih kontak --}}
            <div id="chatPlaceholder" class="flex flex-col items-center justify-center h-full bg-slate-50/50">
                <div class="w-24 h-24 bg-white border border-slate-200 rounded-full flex items-center justify-center mb-5 shadow-sm relative">
                    <div class="absolute inset-0 bg-blue-500/5 rounded-full animate-ping"></div>
                    <i class="mdi mdi-message-text-outline text-4xl text-slate-300 relative z-10"></i>
                </div>
                <h4 class="text-xl font-black text-slate-800 mb-1">Ruang Obrolan Kosong</h4>
                <p class="text-sm font-medium text-slate-500">Pilih salah satu percakapan di samping untuk membalas pesan.</p>
            </div>

            {{-- JENDELA CHAT AKTIF --}}
            <div id="chatActiveWindow" class="hidden flex-col h-full bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] bg-slate-50">

                {{-- Header Chat --}}
                <div class="bg-white/90 backdrop-blur-md px-4 sm:px-6 py-3.5 border-b border-slate-200 flex items-center gap-4 shadow-sm z-10 flex-shrink-0">
                    <button type="button" id="btnBackMobile" class="md:hidden w-10 h-10 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-600 transition-colors">
                        <i class="mdi mdi-arrow-left text-xl leading-none"></i>
                    </button>

                    <div id="activeAvatar" class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 border border-blue-200 flex items-center justify-center font-black text-lg flex-shrink-0">U</div>

                    <div class="flex-1 min-w-0">
                        <h5 id="activeName" class="text-sm font-black text-slate-900 truncate mb-0.5">Nama Pelanggan</h5>
                        <div class="flex items-center gap-1.5" id="user-status-indicator">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_5px_#10b981]"></span>
                            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">Online</span>
                        </div>
                    </div>
                </div>

                {{-- Area Pesan (Balon Chat) --}}
                <div id="messageArea" class="flex-1 p-4 sm:p-6 overflow-y-auto chat-scrollbar flex flex-col gap-4 relative">
                    {{-- Balon pesan akan di-inject JS ke sini --}}
                </div>

                {{-- Animasi Typing Indicator (Ditampilkan saat polling mendeteksi user mengetik) --}}
                <div id="typing-indicator" class="hidden px-6 py-2 pb-4 border-t border-transparent">
                    <div class="flex gap-2.5 max-w-[85%] self-start items-start origin-bottom-left animate-[scale-in_0.2s_ease-out]">
                        <div class="w-8 h-8 rounded-full bg-slate-200 shrink-0 flex items-center justify-center text-slate-500 text-xs mt-auto shadow-sm"><i class="fas fa-user"></i></div>
                        <div class="bg-white border border-slate-200 p-3.5 rounded-2xl rounded-tl-sm shadow-sm flex items-center gap-1.5 h-10">
                            <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce"></span>
                            <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                            <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></span>
                        </div>
                    </div>
                </div>

                {{-- Alat Input Tersembunyi (Hidden) --}}
                <input type="file" id="upload-image" accept="image/*" class="hidden" onchange="handleFileUpload(this, 'image')">
                <input type="file" id="upload-file" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip" class="hidden" onchange="handleFileUpload(this, 'file')">

                {{-- Form Input Bawah --}}
                <div class="bg-white border-t border-slate-200 flex flex-col flex-shrink-0 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] relative z-20">

                    {{-- MEDIA PREVIEW CONTAINER (Baru) --}}
                    <div id="media-preview-container" class="hidden items-center justify-between p-3 mx-4 mt-3 bg-slate-50 border border-slate-200 rounded-xl shadow-inner">
                        <div id="media-preview-content" class="flex items-center gap-3 w-full overflow-hidden">
                            <!-- Preview Injected Here -->
                        </div>
                        <button type="button" onclick="cancelMediaPreview()" class="w-8 h-8 rounded-full bg-red-100 text-red-500 hover:bg-red-200 flex items-center justify-center transition-colors flex-shrink-0 ml-2">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    {{-- Toolbar Media & VN --}}
                    <div class="flex items-center gap-3 px-5 py-2.5 bg-white border-b border-slate-100">
                        <button type="button" onclick="document.getElementById('upload-image').click()" class="text-slate-400 hover:text-blue-600 transition-colors outline-none" title="Kirim Gambar">
                            <i class="mdi mdi-image-outline text-xl leading-none"></i>
                        </button>
                        <button type="button" onclick="document.getElementById('upload-file').click()" class="text-slate-400 hover:text-blue-600 transition-colors outline-none" title="Kirim Dokumen">
                            <i class="mdi mdi-paperclip text-xl leading-none"></i>
                        </button>
                        <button type="button" id="record-vn-btn" onclick="toggleVoiceNote()" class="text-slate-400 hover:text-red-500 transition-colors outline-none relative ml-1" title="Kirim Voice Note">
                            <i class="mdi mdi-microphone text-xl leading-none"></i>
                            <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full animate-ping hidden" id="vn-ping"></span>
                        </button>

                        {{-- Indikator Rekaman --}}
                        <div id="recording-indicator" class="hidden items-center gap-1.5 text-[10px] font-bold text-red-500 bg-red-50 px-2 py-1 rounded-md animate-pulse ml-2">
                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Merekam VN...
                        </div>
                    </div>

                    <form id="formSendMessage" class="p-4 pt-3 flex items-end gap-3">
                        @csrf
                        <input type="hidden" id="activeChatId">

                        <textarea id="inputMessage" class="flex-1 bg-slate-50 border border-slate-200 text-slate-900 text-sm font-medium rounded-xl px-4 py-3 min-h-[44px] max-h-[120px] resize-none focus:bg-white focus:ring-2 focus:ring-blue-600 outline-none transition-all placeholder-slate-400 chat-scrollbar" placeholder="Ketik balasan Anda..."></textarea>

                        <button type="submit" id="btnSendMsg" class="w-11 h-11 rounded-xl bg-blue-600 hover:bg-blue-700 text-white flex items-center justify-center transition-colors shadow-sm shadow-blue-600/20 flex-shrink-0 disabled:opacity-50 disabled:cursor-not-allowed outline-none">
                            <i class="mdi mdi-send text-lg leading-none"></i>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let activeChatId = null;
    let pollingInterval = null;
    let currentMessageCount = -1;
    let pendingMedia = null; // Menyimpan data media sementara sebelum dikirim

    const contactListDiv = document.getElementById('contactList');
    const msgArea = document.getElementById('messageArea');
    const searchInput = document.getElementById('searchContact');
    const msgInput = document.getElementById('inputMessage');
    const typingIndicator = document.getElementById('typing-indicator');

    const pnlChat = document.getElementById('chatPanel');
    const placeholder = document.getElementById('chatPlaceholder');
    const activeWindow = document.getElementById('chatActiveWindow');

    // Mencegah enter mengirim form langsung, shift+enter untuk baris baru
    msgInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            document.getElementById('formSendMessage').dispatchEvent(new Event('submit'));
        }
    });

    document.getElementById('formSendMessage').addEventListener('submit', function(e) {
        e.preventDefault();
        const text = msgInput.value.trim();

        if (pendingMedia) {
            sendMediaMessage(pendingMedia.content, pendingMedia.type, pendingMedia.fileName, text);
            cancelMediaPreview();
        } else if (text !== '') {
            sendMediaMessage(text, 'text');
        }
    });

    // 1. LOAD DAFTAR KONTAK
    function loadChatList() {
        fetch("{{ route('seller.service.chat.list') }}")
            .then(async res => {
                if(!res.ok) throw new Error("Gagal menyinkronkan kontak.");
                return res.json();
            })
            .then(data => {
                let items = data.data || data;
                if(Array.isArray(items)) renderContactList(items);
            })
            .catch(err => console.error(err));
    }

    function renderContactList(chats) {
        contactListDiv.innerHTML = '';
        if(chats.length === 0) {
            contactListDiv.innerHTML = '<div class="text-center py-10 opacity-50"><i class="mdi mdi-message-off-outline text-4xl text-slate-400 block mb-2"></i><p class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">Belum ada pesan.</p></div>';
            return;
        }

        chats.forEach(chat => {
            let nama = chat.nama_pelanggan || chat.nama_toko || 'Customer';
            let id = chat.id || chat.store_id;
            let initial = nama.charAt(0).toUpperCase();

            let badgeUnread = chat.unread_count > 0 ? `<div class="bg-red-500 text-white text-[9px] font-black w-4 h-4 rounded-full flex items-center justify-center absolute -top-1 -right-1 shadow-sm">${chat.unread_count}</div>` : '';
            let isActiveClass = (id == activeChatId) ? 'bg-blue-50/50 border-l-4 border-l-blue-600 pl-3 pr-4' : 'bg-transparent border-l-4 border-l-transparent hover:bg-slate-100/50 px-4';

            let html = `
                <div class="contact-item flex items-center gap-3 py-4 border-b border-slate-100 cursor-pointer transition-colors ${isActiveClass}" data-id="${id}" data-name="${nama}">
                    <div class="w-12 h-12 rounded-full bg-slate-200 text-slate-600 border border-slate-300 flex items-center justify-center font-black text-lg flex-shrink-0 uppercase relative">
                        ${initial}
                        ${badgeUnread}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-center mb-1">
                            <h6 class="text-sm font-bold text-slate-900 truncate pr-2">${nama}</h6>
                            <span class="text-[10px] font-bold text-slate-400 whitespace-nowrap">${chat.time_display || ''}</span>
                        </div>
                        <p class="text-xs font-medium text-slate-500 truncate">${chat.last_message || 'File media terkirim'}</p>
                    </div>
                </div>
            `;
            contactListDiv.insertAdjacentHTML('beforeend', html);
        });
    }

    // 3. KLIK KONTAK BUKA RUANG CHAT
    contactListDiv.addEventListener('click', function(e) {
        let item = e.target.closest('.contact-item');
        if(!item) return;

        contactListDiv.querySelectorAll('.contact-item').forEach(el => {
            el.classList.remove('bg-blue-50/50', 'border-l-blue-600', 'pl-3', 'pr-4');
            el.classList.add('bg-transparent', 'border-l-transparent', 'hover:bg-slate-100/50', 'px-4');
        });
        item.classList.add('bg-blue-50/50', 'border-l-blue-600', 'pl-3', 'pr-4');

        activeChatId = item.dataset.id;
        let cName = item.dataset.name;

        placeholder.classList.add('hidden'); placeholder.classList.remove('flex');
        activeWindow.classList.remove('hidden'); activeWindow.classList.add('flex');
        document.getElementById('activeName').textContent = cName;
        document.getElementById('activeAvatar').textContent = cName.charAt(0).toUpperCase();

        if(window.innerWidth <= 768) {
            pnlChat.classList.remove('hidden', 'translate-x-full');
            pnlChat.classList.add('flex', 'translate-x-0');
        }

        loadMessages(activeChatId, true);
        if(pollingInterval) clearInterval(pollingInterval);
        pollingInterval = setInterval(() => { loadMessages(activeChatId, false); }, 4000);
    });

    // 4. LOAD PESAN (LOGIKA DEWA ANTI FLICKER + CENTANG BIRU)
    function loadMessages(chatId, isInitialLoad = false) {
        if(!chatId) return;
        let url = "{{ route('seller.service.chat.messages', ':id') }}".replace(':id', chatId);

        fetch(url)
            .then(res => res.json())
            .then(data => {
                let items = data.data || data;
                if(!Array.isArray(items)) items = [];

                // Cek status mengetik (Opsional: Jika API memberikan status 'is_typing')
                if(data.is_typing) {
                    typingIndicator.classList.remove('hidden');
                } else {
                    typingIndicator.classList.add('hidden');
                }

                // Hanya render ulang jika jumlah pesan berubah atau loading awal
                if (isInitialLoad || items.length !== currentMessageCount) {
                    msgArea.innerHTML = '';
                    currentMessageCount = items.length;

                    if(items.length === 0) {
                        msgArea.innerHTML = `<div class="text-center text-[10px] font-bold text-slate-400 my-4 bg-white p-2 mx-auto rounded-full border border-slate-200 max-w-[200px] shadow-sm">Belum ada obrolan.</div>`;
                    }

                    items.forEach(msg => {
                        let isOut = msg.sender === 'seller' || msg.is_mine === true;
                        // Pastikan Backend mengirim `is_read`
                        appendMessageUI(msg.content || msg.text, isOut, msg.time, msg.type, msg.fileName, msg.is_read, isInitialLoad);
                    });
                    scrollToBottom();
                } else {
                    // Update Centang Biru Tanpa Refresh Layar
                    updateReadTicks(items);
                }
            })
            .catch(err => console.error(err));
    }

    function scrollToBottom() {
        msgArea.scrollTop = msgArea.scrollHeight;
    }

    // UPDATE TICK REALTIME TANPA FLICKER
    function updateReadTicks(items) {
        const messageElements = msgArea.querySelectorAll('.message-bubble');
        items.forEach((msg, index) => {
            let isOut = msg.sender === 'seller' || msg.is_mine === true;
            if (isOut && msg.is_read == 1 && messageElements[index]) {
                const tickIcon = messageElements[index].querySelector('.chat-tick');
                if (tickIcon && tickIcon.classList.contains('fa-check')) {
                    tickIcon.className = 'chat-tick fas fa-check-double text-blue-500 text-[10px] ml-1';
                }
            }
        });
    }

    // FUNGSI RENDER BALON PESAN (UI MAKER)
    function appendMessageUI(content, isOut, time, type = 'text', fileName = '', isRead = 0, animate = true) {
        let wrapAlign = isOut ? 'self-end items-end' : 'self-start items-start';
        let bubbleColor = isOut ? 'bg-blue-600 text-white rounded-l-2xl rounded-tr-2xl rounded-br-sm shadow-md' : 'bg-white border border-slate-200 text-slate-800 rounded-r-2xl rounded-tl-2xl rounded-bl-sm shadow-sm';
        let timeColor = isOut ? 'text-blue-200' : 'text-slate-400';
        let animClass = animate ? 'animate-[scale-in_0.2s_ease-out]' : '';
        let transformOrigin = isOut ? 'origin-bottom-right' : 'origin-bottom-left';

        // Logika Centang
        let tickHtml = '';
        if(isOut) {
            if(isRead == 1) {
                tickHtml = `<i class="chat-tick fas fa-check-double text-blue-400 text-[10px] ml-1"></i>`;
            } else {
                tickHtml = `<i class="chat-tick fas fa-check text-blue-300 text-[10px] ml-1"></i>`;
            }
        }

        let innerHTML = '';
        if(!type || type === 'text') {
            innerHTML = content;
        } else if (type === 'image') {
            innerHTML = `<div class="p-1"><img src="${content}" class="max-w-[200px] md:max-w-[250px] rounded-xl object-cover hover:opacity-90 transition-opacity" alt="Image"></div>`;
        } else if (type === 'file') {
            innerHTML = `
            <a href="${content}" download="${fileName}" class="flex items-center gap-3 hover:bg-black/10 transition-colors rounded-xl no-underline p-1">
                <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center text-red-600 shrink-0"><i class="mdi mdi-file-pdf-box text-2xl"></i></div>
                <div class="flex flex-col min-w-0 pr-2">
                    <span class="text-xs font-bold truncate max-w-[150px]">${fileName || 'Dokumen'}</span>
                    <span class="text-[9px] uppercase tracking-widest mt-0.5 opacity-80"><i class="mdi mdi-download"></i> Unduh File</span>
                </div>
            </a>`;
        } else if (type === 'audio') {
            innerHTML = `<div class="w-[200px] md:w-[240px] pt-1"><audio controls src="${content}" class="w-full custom-audio"></audio></div>`;
        }

        let html = `
            <div class="message-bubble flex flex-col max-w-[85%] md:max-w-[75%] ${wrapAlign} ${transformOrigin} ${animClass}">
                <div class="px-4 py-2.5 text-[13px] md:text-sm font-medium leading-relaxed break-words ${bubbleColor}">
                    ${innerHTML}
                    <div class="text-[9px] font-bold mt-1.5 text-right ${timeColor} flex items-center justify-end gap-1">
                        ${time} ${tickHtml}
                    </div>
                </div>
            </div>
        `;
        msgArea.insertAdjacentHTML('beforeend', html);
    }

    // ========================================================
    // LOGIKA PREVIEW MEDIA (Menampung Sebelum Dikirim)
    // ========================================================
    window.handleFileUpload = function(inputElement, type) {
        const file = inputElement.files[0];
        if(!file || !activeChatId) return;

        if(file.size > 2000000) { alert('Maksimal ukuran file adalah 2MB.'); return; }

        const reader = new FileReader();
        reader.onload = function(e) {
            showMediaPreview(type, e.target.result, file.name);
        };
        reader.readAsDataURL(file);
        inputElement.value = '';
    }

    let vnRecorder;
    let vnChunks = [];
    let isRecordingVN = false;

    window.toggleVoiceNote = async function() {
        if(!activeChatId) return alert('Pilih chat pelanggan terlebih dahulu!');

        const btn = document.getElementById('record-vn-btn');
        const ping = document.getElementById('vn-ping');
        const indicator = document.getElementById('recording-indicator');

        if(isRecordingVN) {
            vnRecorder.stop();
            isRecordingVN = false;

            btn.classList.remove('text-red-500'); btn.classList.add('text-slate-400');
            ping.classList.add('hidden');
            indicator.classList.add('hidden'); indicator.classList.remove('flex');
        } else {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                vnRecorder = new MediaRecorder(stream);
                vnChunks = [];

                vnRecorder.ondataavailable = e => { if (e.data.size > 0) vnChunks.push(e.data); };
                vnRecorder.onstop = () => {
                    const audioBlob = new Blob(vnChunks, { type: 'audio/webm' });
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        showMediaPreview('audio', e.target.result, 'Voice Note');
                    };
                    reader.readAsDataURL(audioBlob);
                    stream.getTracks().forEach(track => track.stop());
                };

                vnRecorder.start();
                isRecordingVN = true;

                btn.classList.add('text-red-500'); btn.classList.remove('text-slate-400');
                ping.classList.remove('hidden');
                indicator.classList.remove('hidden'); indicator.classList.add('flex');
            } catch (err) {
                alert("Akses Mikrofon ditolak atau tidak ditemukan.");
            }
        }
    }

    // TAMPILKAN PREVIEW DI ATAS INPUT CHAT
    function showMediaPreview(type, content, fileName) {
        pendingMedia = { type, content, fileName };
        const container = document.getElementById('media-preview-container');
        const contentDiv = document.getElementById('media-preview-content');

        if(type === 'image') {
            contentDiv.innerHTML = `<img src="${content}" class="h-12 w-12 object-cover rounded-lg border border-slate-200 shadow-sm"> <div class="flex flex-col"><span class="text-xs font-black text-slate-800 truncate">Gambar Siap Kirim</span><span class="text-[10px] text-slate-400">Tambahkan pesan di bawah...</span></div>`;
        } else if (type === 'file') {
            contentDiv.innerHTML = `<div class="h-12 w-12 bg-red-100 text-red-500 rounded-lg flex items-center justify-center text-xl shadow-sm"><i class="mdi mdi-file-pdf-box"></i></div> <div class="flex flex-col"><span class="text-xs font-black text-slate-800 truncate max-w-[200px]">${fileName}</span><span class="text-[10px] text-slate-400">Dokumen siap kirim</span></div>`;
        } else if (type === 'audio') {
            contentDiv.innerHTML = `<div class="h-12 w-12 bg-blue-100 text-blue-500 rounded-lg flex items-center justify-center text-xl shadow-sm"><i class="mdi mdi-microphone"></i></div> <div class="flex flex-col"><span class="text-xs font-black text-slate-800">Voice Note</span><span class="text-[10px] text-slate-400">Siap dikirim</span></div>`;
        }

        container.classList.remove('hidden'); container.classList.add('flex');
    }

    window.cancelMediaPreview = function() {
        pendingMedia = null;
        const container = document.getElementById('media-preview-container');
        container.classList.add('hidden'); container.classList.remove('flex');
    }

    // LOGIKA PENGIRIMAN FINAL KE BACKEND
    function sendMediaMessage(content, type = 'text', fileName = '', caption = '') {
        if(!content || !activeChatId) return;

        let btn = document.getElementById('btnSendMsg');
        btn.disabled = true;
        btn.innerHTML = '<i class="mdi mdi-loading mdi-spin text-xl leading-none"></i>';

        const timeNow = new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'});

        // Optimistic Tampil ke Layar (1 Centang)
        appendMessageUI(content, true, timeNow, type, fileName, 0, true);

        if (caption && type !== 'text') {
            // Jika ada caption, kirim juga captionnya
            setTimeout(() => appendMessageUI(caption, true, timeNow, 'text', '', 0, true), 100);
        }

        scrollToBottom();
        currentMessageCount++;
        msgInput.value = '';

        let payload = { chat_id: activeChatId, message: content, type: type, file_name: fileName };

        fetch("{{ route('seller.service.chat.send') }}", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value },
            body: JSON.stringify(payload)
        })
        .then(async res => {
            if(!res.ok) throw new Error("Gagal mengirim ke server.");
            return res.json();
        })
        .then(data => {
            if (caption && type !== 'text') {
                // Eksekusi API kedua untuk caption
                fetch("{{ route('seller.service.chat.send') }}", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value },
                    body: JSON.stringify({ chat_id: activeChatId, message: caption, type: 'text' })
                });
            }
            loadChatList();
        })
        .catch(err => { console.error(err); })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="mdi mdi-send text-lg leading-none"></i>';
            msgInput.focus();
        });
    }

    document.getElementById('btnBackMobile').addEventListener('click', function() {
        pnlChat.classList.add('hidden', 'translate-x-full');
        pnlChat.classList.remove('flex', 'translate-x-0');
        if(pollingInterval) clearInterval(pollingInterval);
        activeChatId = null;
        placeholder.classList.remove('hidden'); placeholder.classList.add('flex');
        activeWindow.classList.add('hidden'); activeWindow.classList.remove('flex');
        loadChatList();
    });

    const style = document.createElement('style');
    style.innerHTML = `@keyframes scale-in { 0% { transform: scale(0.95); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }`;
    document.head.appendChild(style);

    loadChatList();
});
</script>
@endpush
