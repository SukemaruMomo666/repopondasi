@extends('layouts.seller')

@section('title', 'Profil Toko & Legalitas')

@push('styles')
{{-- LEAFLET CSS UNTUK PETA --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    /* Animasi Upload Hover */
    .upload-hover:hover .upload-overlay { opacity: 1; }
    
    /* Fix z-index Leaflet agar tidak nabrak navbar/modal */
    .leaflet-container { z-index: 10 !important; }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-slate-50 p-4 md:p-6 lg:p-8 font-sans text-slate-900 pb-32">

    {{-- SETUP SWEETALERT TOAST --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true, position: 'top-end', showConfirmButton: false, timer: 3000,
            customClass: { popup: 'rounded-2xl shadow-lg border border-slate-100' }
        });
    </script>
    @if(session('success'))
        <script>document.addEventListener('DOMContentLoaded', () => Toast.fire({icon: 'success', title: '{{ session('success') }}'}));</script>
    @endif
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl mb-6 shadow-sm flex items-start gap-3">
            <i class="mdi mdi-alert-circle text-xl mt-0.5"></i>
            <div>
                <h5 class="font-bold text-sm mb-1">Gagal Menyimpan!</h5>
                <ul class="list-disc list-inside text-xs font-medium space-y-0.5">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- HEADER --}}
    <div class="flex items-center gap-4 mb-8">
        <div class="w-12 h-12 bg-white border border-slate-200 rounded-2xl flex items-center justify-center text-blue-600 shadow-sm flex-shrink-0">
            <i class="mdi mdi-store-cog-outline text-2xl"></i>
        </div>
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Profil & Legalitas Toko</h1>
            <p class="text-sm font-medium text-slate-500 mt-0.5">Atur identitas, logo, kebijakan, dan dokumen legal (B2B) Anda.</p>
        </div>
    </div>

    <form action="{{ route('seller.shop.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            {{-- KOLOM KIRI: TAMPILAN VISUAL (Logo & Banner) --}}
            <div class="lg:col-span-4 space-y-6">

                {{-- LOGO TOKO --}}
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm text-center">
                    <h3 class="text-sm font-black text-slate-800 mb-4 text-left"><i class="mdi mdi-image-outline text-blue-500 me-1"></i> Logo Toko</h3>

                    <div class="relative w-40 h-40 mx-auto rounded-full border-4 border-slate-50 shadow-md overflow-hidden group upload-hover cursor-pointer" onclick="document.getElementById('logoInput').click()">
                        @php $logoUrl = !empty($toko->logo_toko) ? asset('assets/uploads/logos/'.$toko->logo_toko) : 'https://placehold.co/200x200?text=Logo'; @endphp
                        <img id="logoPreview" src="{{ $logoUrl }}" class="w-full h-full object-cover" alt="Logo Toko">

                        {{-- Overlay Edit --}}
                        <div class="upload-overlay absolute inset-0 bg-slate-900/50 flex flex-col items-center justify-center text-white opacity-0 transition-opacity duration-300">
                            <i class="mdi mdi-camera-plus text-3xl mb-1"></i>
                            <span class="text-[10px] font-bold uppercase tracking-widest">Ubah Logo</span>
                        </div>
                    </div>
                    <input type="file" id="logoInput" name="logo_toko" class="hidden" accept="image/png, image/jpeg, image/webp" onchange="previewImage(this, 'logoPreview')">

                    <p class="text-xs font-medium text-slate-500 mt-4 leading-relaxed">
                        Format: JPG, PNG, WEBP.<br>Ukuran maksimal: 2MB.<br>Rekomendasi: 300x300 pixel.
                    </p>
                </div>

                {{-- BANNER TOKO --}}
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm">
                    <h3 class="text-sm font-black text-slate-800 mb-4"><i class="mdi mdi-panorama-variant-outline text-indigo-500 me-1"></i> Banner Toko</h3>

                    <div class="relative w-full h-32 rounded-2xl border-2 border-dashed border-slate-300 overflow-hidden group upload-hover cursor-pointer bg-slate-50 flex flex-col items-center justify-center" onclick="document.getElementById('bannerInput').click()">
                        @if(!empty($toko->banner_toko))
                            <img id="bannerPreview" src="{{ asset('assets/uploads/banners/'.$toko->banner_toko) }}" class="absolute inset-0 w-full h-full object-cover z-0" alt="Banner">
                        @else
                            <img id="bannerPreview" src="" class="absolute inset-0 w-full h-full object-cover z-0 hidden" alt="Banner">
                            <div id="bannerPlaceholder" class="relative z-10 text-center text-slate-400 group-hover:text-indigo-500 transition-colors">
                                <i class="mdi mdi-cloud-upload-outline text-3xl block mb-1"></i>
                                <span class="text-xs font-bold">Upload Banner</span>
                            </div>
                        @endif

                        {{-- Overlay Edit --}}
                        <div class="upload-overlay absolute inset-0 bg-slate-900/50 flex flex-col items-center justify-center text-white opacity-0 transition-opacity duration-300 z-20">
                            <i class="mdi mdi-camera-retake text-2xl mb-1"></i>
                            <span class="text-[10px] font-bold uppercase tracking-widest">Ubah Banner</span>
                        </div>
                    </div>
                    <input type="file" id="bannerInput" name="banner_toko" class="hidden" accept="image/png, image/jpeg, image/webp" onchange="previewImage(this, 'bannerPreview', 'bannerPlaceholder')">

                    <p class="text-xs font-medium text-slate-500 mt-3 leading-relaxed text-center">
                        Maksimal 5MB. Rasio optimal 16:9 (Cth: 1200x400px).
                    </p>
                </div>

            </div>

            {{-- KOLOM KANAN: INFORMASI TEKS & LEGALITAS --}}
            <div class="lg:col-span-8 space-y-6">

                {{-- IDENTITAS TOKO --}}
                <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm">
                    <div class="bg-slate-50/80 px-6 py-4 border-b border-slate-100 flex items-center gap-2">
                        <i class="mdi mdi-store-edit text-blue-600 text-lg leading-none"></i>
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Identitas Toko</h3>
                    </div>
                    <div class="p-6 space-y-5">

                        <div>
                            <div class="flex justify-between items-end mb-2">
                                <label class="text-sm font-bold text-slate-700">Nama Toko <span class="text-red-500">*</span></label>
                                <span class="text-[10px] font-bold text-slate-400" id="countNama">0/50</span>
                            </div>
                            <input type="text" name="nama_toko" id="inputNama" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-bold rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-blue-600 outline-none transition-all" value="{{ old('nama_toko', $toko->nama_toko ?? '') }}" maxlength="50" required>
                        </div>

                        <div>
                            <div class="flex justify-between items-end mb-2">
                                <label class="text-sm font-bold text-slate-700">Slogan / Tagline</label>
                                <span class="text-[10px] font-bold text-slate-400" id="countSlogan">0/100</span>
                            </div>
                            <input type="text" name="slogan" id="inputSlogan" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-semibold rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-blue-600 outline-none transition-all" value="{{ old('slogan', $toko->slogan ?? '') }}" placeholder="Cth: Material Berkualitas, Harga Pantas" maxlength="100">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Singkat Toko</label>
                            <textarea name="deskripsi_toko" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-medium rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-blue-600 outline-none transition-all min-h-[120px] resize-none" placeholder="Ceritakan tentang toko, spesialisasi material, atau keunggulan Anda...">{{ old('deskripsi_toko', $toko->deskripsi_toko ?? '') }}</textarea>
                        </div>

                    </div>
                </div>

                {{-- KEBIJAKAN & CATATAN B2B --}}
                <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm">
                    <div class="bg-amber-50/80 px-6 py-4 border-b border-amber-100 flex items-center gap-2">
                        <i class="mdi mdi-shield-check text-amber-600 text-lg leading-none"></i>
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Kebijakan B2B</h3>
                    </div>
                    <div class="p-6 space-y-5">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Catatan Toko (S&K Pemesanan)</label>
                                <textarea name="catatan_toko" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-medium rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-amber-500 outline-none transition-all min-h-[120px] resize-none" placeholder="Cth: Pesanan di atas jam 14.00 akan dikirim besok. Truk hanya bisa masuk jalan aspal...">{{ old('catatan_toko', $toko->catatan_toko ?? '') }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Kebijakan Retur Material</label>
                                <textarea name="kebijakan_retur" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-medium rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-amber-500 outline-none transition-all min-h-[120px] resize-none" placeholder="Cth: Semen yang sudah mengeras tidak dapat ditukar. Besi yang sudah dipotong tidak bisa diretur...">{{ old('kebijakan_retur', $toko->kebijakan_retur ?? '') }}</textarea>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- DOKUMEN LEGAL B2B --}}
                <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm">
                    <div class="bg-slate-50/80 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <i class="mdi mdi-file-document-check text-indigo-600 text-lg leading-none"></i>
                            <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Dokumen Legalitas (Opsional)</h3>
                        </div>
                        @if($toko->tier_toko == 'official_store')
                            <span class="bg-purple-100 text-purple-700 text-[10px] font-black px-2.5 py-1 rounded-md">VERIFIED OFFICIAL</span>
                        @endif
                    </div>
                    <div class="p-6 space-y-5">
                        <p class="text-xs font-bold text-slate-500 mb-4">Unggah dokumen ini jika Anda ingin mengajukan diri sebagai <b>Power Merchant</b> atau <b>Official Store</b> untuk memenangkan tender besar.</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Upload File NIB (PDF/Gambar)</label>
                                <input type="file" name="dokumen_nib" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl px-4 py-2 focus:bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept=".pdf,image/*">
                                @if(!empty($toko->dokumen_nib))
                                    <div class="mt-2 text-xs font-bold text-emerald-600 flex items-center gap-1"><i class="mdi mdi-check-circle"></i> File NIB sudah tersimpan.</div>
                                @endif
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Upload File NPWP Perusahaan</label>
                                <input type="file" name="dokumen_npwp" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl px-4 py-2 focus:bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept=".pdf,image/*">
                                @if(!empty($toko->dokumen_npwp))
                                    <div class="mt-2 text-xs font-bold text-emerald-600 flex items-center gap-1"><i class="mdi mdi-check-circle"></i> File NPWP sudah tersimpan.</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KONTAK & ALAMAT & MAPS --}}
                <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm">
                    <div class="bg-slate-50/80 px-6 py-4 border-b border-slate-100 flex items-center gap-2">
                        <i class="mdi mdi-map-marker-radius text-emerald-600 text-lg leading-none"></i>
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Kontak & Alamat Pengiriman</h3>
                    </div>
                    <div class="p-6 space-y-5">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Nomor WhatsApp/Telepon <span class="text-red-500">*</span></label>
                                <div class="flex border border-slate-200 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-emerald-500 transition-all">
                                    <span class="bg-slate-100 px-4 py-3 text-slate-500 font-black border-r border-slate-200">+62</span>
                                    <input type="text" name="no_telepon" class="w-full bg-slate-50 px-4 py-3 text-sm font-bold outline-none" value="{{ old('no_telepon', ltrim($toko->telepon_toko ?? '', '0')) }}" placeholder="8123456789" pattern="[0-9]+" required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Kabupaten/Kota (Manual) <span class="text-red-500">*</span></label>
                                <input type="text" name="kota" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-bold rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-emerald-500 outline-none transition-all" value="{{ old('kota', 'Silakan Set Ulang Alamat') }}" placeholder="Cth: Kab. Subang" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Lengkap Toko/Gudang <span class="text-red-500">*</span></label>
                            <textarea name="alamat_lengkap" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-medium rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-emerald-500 outline-none transition-all min-h-[80px] resize-none" placeholder="Nama Jalan, RT/RW, Patokan..." required>{{ old('alamat_lengkap', $toko->alamat_toko ?? '') }}</textarea>
                        </div>

                        <div class="w-full md:w-1/2 mb-5">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Kode Pos <span class="text-red-500">*</span></label>
                            <input type="text" name="kode_pos" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-bold rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-emerald-500 outline-none transition-all" value="{{ old('kode_pos', $toko->kode_pos ?? '') }}" pattern="[0-9]{5,6}" required>
                        </div>

                        <hr class="border-slate-100">

                        {{-- SEKSI PETA LOKASI LEAFLET --}}
                        <div class="pt-2">
                            <label class="block text-sm font-black text-slate-800 mb-2">Titik Koordinat Peta <span class="text-red-500">*</span></label>
                            <p class="text-xs font-medium text-slate-500 mb-3">Tentukan titik presisi lokasi toko untuk memudahkan kurir/truk pengiriman barang berat. Cari nama daerah, lalu geser pin merah.</p>

                            {{-- Fitur Search Geocoding --}}
                            <div class="flex gap-2 mb-3">
                                <input type="text" id="searchLokasi" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-bold rounded-xl px-4 py-2.5 focus:bg-white focus:ring-2 focus:ring-emerald-500 outline-none transition-all" placeholder="Ketik nama jalan / daerah...">
                                <button type="button" onclick="cariLokasiMap()" class="bg-slate-800 hover:bg-slate-900 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-md transition-colors whitespace-nowrap">
                                    <i class="mdi mdi-magnify"></i> Cari
                                </button>
                            </div>

                            {{-- Container Peta --}}
                            <div id="map" class="w-full h-[350px] rounded-2xl border-2 border-slate-200 shadow-inner z-10 relative"></div>

                            {{-- Input Hidden/Readonly Koordinat --}}
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase tracking-widest">Latitude</label>
                                    <input type="text" name="latitude" id="latitude" class="w-full bg-slate-100 border border-slate-200 text-slate-600 text-xs font-black rounded-lg px-3 py-2 outline-none cursor-not-allowed" value="{{ old('latitude', $toko->latitude ?? '-6.558935') }}" readonly required>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase tracking-widest">Longitude</label>
                                    <input type="text" name="longitude" id="longitude" class="w-full bg-slate-100 border border-slate-200 text-slate-600 text-xs font-black rounded-lg px-3 py-2 outline-none cursor-not-allowed" value="{{ old('longitude', $toko->longitude ?? '107.763321') }}" readonly required>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        {{-- STICKY ACTION BAR BAWAH --}}
        <div class="fixed bottom-0 left-0 lg:left-[260px] right-0 bg-white/80 backdrop-blur-md border-t border-slate-200 px-6 py-4 flex items-center justify-between z-40 shadow-[0_-10px_15px_-3px_rgba(0,0,0,0.05)]">
            <div class="hidden sm:block">
                <p class="text-xs font-bold text-slate-500 m-0"><i class="mdi mdi-information text-blue-500"></i> Pastikan perubahan sudah benar sebelum menyimpan.</p>
            </div>
            <div class="flex gap-3 w-full sm:w-auto">
                <a href="{{ route('seller.dashboard') }}" class="flex-1 sm:flex-none text-center px-6 py-2.5 bg-slate-100 text-slate-700 font-bold rounded-xl hover:bg-slate-200 transition-colors">Kembali</a>
                <button type="submit" id="btnSubmitProfile" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-8 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-sm shadow-blue-600/20 transition-all">
                    <i class="mdi mdi-content-save"></i> Simpan Profil
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
{{-- SCRIPT LEAFLET UNTUK MAPS --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Inisialisasi Kordinat (Default: Area Subang atau Kordinat Toko Sebelumnya)
    var latInput = document.getElementById('latitude');
    var lngInput = document.getElementById('longitude');
    
    var startLat = parseFloat(latInput.value) || -6.558935;
    var startLng = parseFloat(lngInput.value) || 107.763321;

    // Buat Peta
    var map = L.map('map').setView([startLat, startLng], 14);

    // Tambahkan Tile Layer (Tampilan Jalan OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Tambahkan Pin/Marker yang bisa digeser (Draggable)
    var marker = L.marker([startLat, startLng], {
        draggable: true
    }).addTo(map);

    // Event saat pin digeser
    marker.on('dragend', function (e) {
        var coords = e.target.getLatLng();
        latInput.value = coords.lat.toFixed(8);
        lngInput.value = coords.lng.toFixed(8);
    });

    // Event saat peta diklik (Pin pindah ke titik klik)
    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        latInput.value = e.latlng.lat.toFixed(8);
        lngInput.value = e.latlng.lng.toFixed(8);
    });

    // Fungsi Pencarian Lokasi menggunakan API Nominatim (Gratis)
    function cariLokasiMap() {
        var query = document.getElementById('searchLokasi').value;
        if(query.length < 3) {
            alert('Ketik minimal 3 huruf untuk mencari.');
            return;
        }

        // Tampilkan loading di tombol
        var btn = event.currentTarget;
        var originalText = btn.innerHTML;
        btn.innerHTML = '<i class="mdi mdi-loading mdi-spin"></i> Mencari...';

        fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(query))
            .then(response => response.json())
            .then(data => {
                btn.innerHTML = originalText; // Kembalikan tombol
                if(data && data.length > 0) {
                    var newLat = data[0].lat;
                    var newLon = data[0].lon;
                    
                    // Pindah view peta dan letakkan marker
                    map.setView([newLat, newLon], 16);
                    marker.setLatLng([newLat, newLon]);
                    
                    // Update input hidden
                    latInput.value = parseFloat(newLat).toFixed(8);
                    lngInput.value = parseFloat(newLon).toFixed(8);
                } else {
                    Swal.fire({icon: 'error', title: 'Oops...', text: 'Lokasi tidak ditemukan. Coba nama yang lebih spesifik.', customClass: { popup: 'rounded-2xl' }});
                }
            }).catch(err => {
                btn.innerHTML = originalText;
                alert('Gagal mencari lokasi. Cek koneksi internet Anda.');
            });
    }

    // Biar search bisa pake tombol Enter
    document.getElementById('searchLokasi').addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            cariLokasiMap();
        }
    });

    // ----------------------------------------------------
    // SCRIPT ORIGINAL LAINNYA
    // ----------------------------------------------------
    
    // 1. LIVE PREVIEW IMAGE (Logo & Banner)
    function previewImage(input, previewId, placeholderId = null) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                const previewImg = document.getElementById(previewId);
                previewImg.src = e.target.result;
                previewImg.classList.remove('hidden'); 

                if(placeholderId) {
                    document.getElementById(placeholderId).classList.add('hidden');
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // 2. CHARACTER COUNTER
    function initCounter(inputId, counterId, maxLen) {
        const input = document.getElementById(inputId);
        const counter = document.getElementById(counterId);

        if(!input || !counter) return;

        const updateCount = () => {
            let len = input.value.length;
            counter.textContent = `${len}/${maxLen}`;
            if(len >= maxLen) counter.classList.replace('text-slate-400', 'text-red-500');
            else counter.classList.replace('text-red-500', 'text-slate-400');
        };

        input.addEventListener('input', updateCount);
        updateCount(); 
    }

    initCounter('inputNama', 'countNama', 50);
    initCounter('inputSlogan', 'countSlogan', 100);

    // 3. LOADING STATE SUBMIT
    document.getElementById('profileForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmitProfile');
        btn.innerHTML = '<i class="mdi mdi-loading mdi-spin"></i> Menyimpan...';
        btn.disabled = true;
        btn.classList.add('opacity-70', 'cursor-not-allowed');
    });
</script>
@endpush