@extends('layouts.seller')

@section('title', 'Pusat Pesan (Chat)')

@push('styles')
<style>
    /* Styling khusus scrollbar Chat agar terlihat seperti Mac/iOS */
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
                        <div class="flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_5px_#10b981]"></span>
                            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">Online</span>
                        </div>
                    </div>
                </div>

                {{-- Area Pesan (Balon Chat) --}}
                <div id="messageArea" class="flex-1 p-4 sm:p-6 overflow-y-auto chat-scrollbar flex flex-col gap-4">
                    {{-- Balon pesan akan di-inject JS ke sini --}}
                </div>

                {{-- Alat Input Tersembunyi (Hidden) --}}
                <input type="file" id="upload-image" accept="image/*" class="hidden" onchange="handleFileUpload(this, 'image')">
                <input type="file" id="upload-file" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip" class="hidden" onchange="handleFileUpload(this, 'file')">

                {{-- Form Input Bawah --}}
                <div class="bg-white border-t border-slate-200 flex flex-col flex-shrink-0 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] relative z-20">

                    {{-- Toolbar Media & VN --}}
                    <div class="flex items-center gap-3 px-5 py-2.5 bg-slate-50/50 border-b border-slate-100">
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

                        <textarea id="inputMessage" class="flex-1 bg-slate-50 border border-slate-200 text-slate-900 text-sm font-medium rounded-xl px-4 py-3 min-h-[44px] max-h-[120px] resize-none focus:bg-white focus:ring-2 focus:ring-blue-600 outline-none transition-all placeholder-slate-400 chat-scrollbar" placeholder="Ketik balasan Anda..." required></textarea>

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

    const contactListDiv = document.getElementById('contactList');
    const msgArea = document.getElementById('messageArea');
    const searchInput = document.getElementById('searchContact');
    const msgInput = document.getElementById('inputMessage');

    const pnlSidebar = document.getElementById('sidebarPanel');
    const pnlChat = document.getElementById('chatPanel');
    const placeholder = document.getElementById('chatPlaceholder');
    const activeWindow = document.getElementById('chatActiveWindow');

    // Mencegah enter mengirim form langsung, shift+enter untuk baris baru
    msgInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMediaMessage(msgInput.value.trim(), 'text');
        }
    });

    document.getElementById('formSendMessage').addEventListener('submit', function(e) {
        e.preventDefault();
        sendMediaMessage(msgInput.value.trim(), 'text');
    });

    // 1. LOAD DAFTAR KONTAK (CHAT LIST)
    function loadChatList() {
        fetch("{{ route('seller.service.chat.list') }}")
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    renderContactList(data.data);
                } else if (Array.isArray(data)) { // Fallback jika controller return langsung array
                    renderContactList(data);
                }
            })
            .catch(err => {
                contactListDiv.innerHTML = '<div class="text-center py-10 text-red-500 font-bold text-xs"><i class="mdi mdi-alert-circle text-2xl block mb-2"></i>Gagal memuat kontak.</div>';
            });
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

            // Format Badge
            let badgeUnread = chat.unread_count > 0 ? `<div class="bg-red-500 text-white text-[9px] font-black w-4 h-4 rounded-full flex items-center justify-center absolute -top-1 -right-1">${chat.unread_count}</div>` : '';
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
                            <span class="text-[10px] font-bold text-slate-400 whitespace-nowrap">${chat.time_display || chat.last_time || ''}</span>
                        </div>
                        <p class="text-xs font-medium text-slate-500 truncate">${chat.last_message || 'File media terkirim'}</p>
                    </div>
                </div>
            `;
            contactListDiv.insertAdjacentHTML('beforeend', html);
        });
    }

    // 2. FITUR PENCARIAN KONTAK LOKAL
    searchInput.addEventListener('keyup', function() {
        let keyword = this.value.toLowerCase();
        let items = contactListDiv.querySelectorAll('.contact-item');
        items.forEach(item => {
            let name = item.querySelector('h6').textContent.toLowerCase();
            if (name.includes(keyword)) {
                item.classList.remove('hidden'); item.classList.add('flex');
            } else {
                item.classList.remove('flex'); item.classList.add('hidden');
            }
        });
    });

    // 3. KLIK KONTAK BUKA RUANG CHAT
    contactListDiv.addEventListener('click', function(e) {
        let item = e.target.closest('.contact-item');
        if(!item) return;

        // Set Active State Visual UI
        contactListDiv.querySelectorAll('.contact-item').forEach(el => {
            el.classList.remove('bg-blue-50/50', 'border-l-blue-600', 'pl-3', 'pr-4');
            el.classList.add('bg-transparent', 'border-l-transparent', 'hover:bg-slate-100/50', 'px-4');
        });
        item.classList.remove('bg-transparent', 'border-l-transparent', 'hover:bg-slate-100/50', 'px-4');
        item.classList.add('bg-blue-50/50', 'border-l-blue-600', 'pl-3', 'pr-4');

        activeChatId = item.dataset.id;
        let cName = item.dataset.name;

        // UI Updates
        placeholder.classList.add('hidden'); placeholder.classList.remove('flex');
        activeWindow.classList.remove('hidden'); activeWindow.classList.add('flex');

        document.getElementById('activeName').textContent = cName;
        document.getElementById('activeAvatar').textContent = cName.charAt(0).toUpperCase();
        document.getElementById('activeChatId').value = activeChatId;

        // Mode Mobile: Slide Panel
        if(window.innerWidth <= 768) {
            pnlChat.classList.remove('hidden', 'translate-x-full');
            pnlChat.classList.add('flex', 'translate-x-0');
        }

        // Load Pesan
        loadMessages(activeChatId, true);
        if(pollingInterval) clearInterval(pollingInterval);
        pollingInterval = setInterval(() => { loadMessages(activeChatId, false); }, 4000);
    });

    // 4. LOAD PESAN DARI DATABASE (SUPPORT MEDIA)
    function loadMessages(chatId, forceScroll = false) {
        if(!chatId) return;
        let url = "{{ route('seller.service.chat.messages', ':id') }}".replace(':id', chatId);

        fetch(url)
            .then(res => res.json())
            .then(data => {
                let items = data.data || data; // Handle jika root response adalah array
                msgArea.innerHTML = '';

                items.forEach(msg => {
                    // Cek logic sender (apabila API dari customer mengirim 'user', berarti 'seller' adalah diri kita disini)
                    // Sesuaikan 'seller' sebagai diri sendiri (isOut = true)
                    let isOut = msg.sender === 'seller' || msg.is_mine === true;
                    appendMessageUI(msg.content || msg.text, isOut, msg.time, msg.type, msg.fileName);
                });

                if(forceScroll) scrollToBottom();
            });
    }

    function scrollToBottom() {
        msgArea.scrollTop = msgArea.scrollHeight;
    }

    // FUNGSI RENDER BALON PESAN (UI MAKER)
    function appendMessageUI(content, isOut, time, type = 'text', fileName = '') {
        let wrapAlign = isOut ? 'self-end items-end' : 'self-start items-start';
        let bubbleColor = isOut ? 'bg-blue-600 text-white rounded-l-2xl rounded-tr-2xl rounded-br-sm shadow-md' : 'bg-white border border-slate-200 text-slate-800 rounded-r-2xl rounded-tl-2xl rounded-bl-sm shadow-sm';
        let timeColor = isOut ? 'text-blue-200' : 'text-slate-400';

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
            <div class="flex flex-col max-w-[85%] md:max-w-[75%] ${wrapAlign} origin-bottom animate-[scale-in_0.2s_ease-out]">
                <div class="px-4 py-2.5 text-[13px] md:text-sm font-medium leading-relaxed break-words ${bubbleColor}">
                    ${innerHTML}
                    <div class="text-[9px] font-bold mt-1.5 text-right ${timeColor}">${time}</div>
                </div>
            </div>
        `;
        msgArea.insertAdjacentHTML('beforeend', html);
        scrollToBottom();
    }

    // 5. KIRIM PESAN & MEDIA AJAX
    window.handleFileUpload = function(inputElement, type) {
        const file = inputElement.files[0];
        if(!file || !activeChatId) return;

        if(file.size > 2000000) {
            alert('Maksimal ukuran file adalah 2MB.');
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            const base64data = e.target.result;
            sendMediaMessage(base64data, type, file.name);
        };
        reader.readAsDataURL(file);
        inputElement.value = '';
    }

    // UNTUK VOICE NOTE (MediaRecorder)
    let vnRecorder;
    let vnChunks = [];
    let isRecordingVN = false;

    window.toggleVoiceNote = async function() {
        if(!activeChatId) return alert('Pilih chat pelanggan terlebih dahulu!');

        const btn = document.getElementById('record-vn-btn');
        const ping = document.getElementById('vn-ping');
        const indicator = document.getElementById('recording-indicator');

        if(isRecordingVN) {
            // Berhenti rekam
            vnRecorder.stop();
            isRecordingVN = false;

            btn.classList.remove('text-red-500'); btn.classList.add('text-slate-400');
            ping.classList.add('hidden');
            indicator.classList.add('hidden'); indicator.classList.remove('flex');
        } else {
            // Mulai rekam
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                vnRecorder = new MediaRecorder(stream);
                vnChunks = [];

                vnRecorder.ondataavailable = e => { if (e.data.size > 0) vnChunks.push(e.data); };
                vnRecorder.onstop = () => {
                    const audioBlob = new Blob(vnChunks, { type: 'audio/webm' });
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        sendMediaMessage(e.target.result, 'audio', 'Voice Note');
                    };
                    reader.readAsDataURL(audioBlob);
                    stream.getTracks().forEach(track => track.stop()); // Matikan Mic
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

    // LOGIKA PENGIRIMAN UTAMA (Mendukung semua Tipe)
    function sendMediaMessage(content, type = 'text', fileName = '') {
        if(!content || !activeChatId) return;

        let btn = document.getElementById('btnSendMsg');
        btn.disabled = true;
        btn.innerHTML = '<i class="mdi mdi-loading mdi-spin text-xl leading-none"></i>';

        // Optimistic UI (Tampil Langsung)
        const timeNow = new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'});
        appendMessageUI(content, true, timeNow, type, fileName);
        if(type === 'text') msgInput.value = '';

        // API Payloads
        let payload = {
            chat_id: activeChatId,
            message: content,
            type: type,
            file_name: fileName
        };

        fetch("{{ route('seller.service.chat.send') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            // Refresh tanpa scroll paksa
            loadChatList();
        })
        .catch(err => {
            console.error("Pesan gagal, tapi tetap tampil sebagai fallback demo", err);
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="mdi mdi-send text-lg leading-none"></i>';
            msgInput.focus();
        });
    }

    // 6. TOMBOL BACK MOBILE
    document.getElementById('btnBackMobile').addEventListener('click', function() {
        pnlChat.classList.add('hidden', 'translate-x-full');
        pnlChat.classList.remove('flex', 'translate-x-0');

        if(pollingInterval) clearInterval(pollingInterval);
        activeChatId = null;

        contactListDiv.querySelectorAll('.contact-item').forEach(el => {
            el.classList.remove('bg-blue-50/50', 'border-l-blue-600', 'pl-3', 'pr-4');
            el.classList.add('bg-transparent', 'border-l-transparent', 'hover:bg-slate-100/50', 'px-4');
        });

        placeholder.classList.remove('hidden'); placeholder.classList.add('flex');
        activeWindow.classList.add('hidden'); activeWindow.classList.remove('flex');

        loadChatList();
    });

    // CSS Keyframe Injection
    const style = document.createElement('style');
    style.innerHTML = `@keyframes scale-in { 0% { transform: scale(0.95); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }`;
    document.head.appendChild(style);

});
</script>
@endpush
