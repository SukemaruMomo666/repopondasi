@extends('layouts.seller')

@section('title', 'Profil & Legalitas Toko')

@push('styles')
{{-- LEAFLET CSS - WAJIB UNTUK PETA --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    .upload-hover:hover .upload-overlay { opacity: 1; }
    
    /* STYLING PETA AGAR TIDAK BUG/PECAH */
    #map { 
        width: 100% !important; 
        height: 400px !important; 
        border-radius: 1.5rem; 
        border: 2px solid #e2e8f0;
        z-index: 1 !important; 
    }
    .leaflet-tile-container img { width: 256.5px !important; height: 256.5px !important; }

    /* Input Readonly Look */
    .input-auto { background-color: #f1f5f9 !important; color: #475569 !important; cursor: not-allowed; border-color: #e2e8f0 !important; font-weight: 700; }
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

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-200">
                <i class="mdi mdi-store-check text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Manajemen Profil B2B</h1>
                <p class="text-sm font-medium text-slate-500 mt-0.5">Lengkapi data legalitas dan titik jemput logistik armada berat.</p>
            </div>
        </div>
        @if(($toko->tier_toko ?? '') == 'official_store')
            <div class="bg-purple-100 text-purple-700 px-4 py-2 rounded-xl border border-purple-200 flex items-center gap-2">
                <i class="mdi mdi-check-decagram text-xl"></i>
                <span class="text-xs font-black uppercase tracking-wider">Official Store Verified</span>
            </div>
        @endif
    </div>

    <form action="{{ route('seller.shop.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            {{-- KOLOM KIRI: VISUAL & DATA LEGAL --}}
            <div class="lg:col-span-4 space-y-6">
                
                {{-- LOGO & BANNER --}}
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm">
                    <h3 class="text-sm font-black text-slate-800 mb-6 flex items-center gap-2">
                        <i class="mdi mdi-image-multiple text-blue-500"></i> Visual Branding
                    </h3>
                    
                    {{-- Logo --}}
                    <div class="relative w-32 h-32 mx-auto rounded-3xl border-4 border-slate-50 shadow-md overflow-hidden group upload-hover cursor-pointer mb-6" onclick="document.getElementById('logoInput').click()">
                        @php $logoUrl = !empty($toko->logo_toko) ? asset('assets/uploads/logos/'.$toko->logo_toko) : 'https://placehold.co/200x200?text=Logo'; @endphp
                        <img id="logoPreview" src="{{ $logoUrl }}" class="w-full h-full object-cover">
                        <div class="upload-overlay absolute inset-0 bg-slate-900/50 flex flex-col items-center justify-center text-white opacity-0 transition-opacity">
                            <i class="mdi mdi-camera text-2xl"></i>
                        </div>
                    </div>
                    <input type="file" id="logoInput" name="logo_toko" class="hidden" accept="image/*" onchange="previewImage(this, 'logoPreview')">

                    {{-- Banner --}}
                    <div class="relative w-full h-28 rounded-2xl border-2 border-dashed border-slate-200 overflow-hidden group upload-hover cursor-pointer bg-slate-50 flex items-center justify-center" onclick="document.getElementById('bannerInput').click()">
                        @if(!empty($toko->banner_toko))
                            <img id="bannerPreview" src="{{ asset('assets/uploads/banners/'.$toko->banner_toko) }}" class="absolute inset-0 w-full h-full object-cover">
                        @else
                            <img id="bannerPreview" src="" class="absolute inset-0 w-full h-full object-cover hidden">
                            <div id="bannerPlaceholder" class="text-center text-slate-400">
                                <i class="mdi mdi-upload text-2xl"></i>
                                <div class="text-[10px] font-bold">Upload Banner</div>
                            </div>
                        @endif
                        <div class="upload-overlay absolute inset-0 bg-slate-900/50 flex items-center justify-center text-white opacity-0 transition-opacity z-20">
                            <i class="mdi mdi-image-edit text-xl"></i>
                        </div>
                    </div>
                    <input type="file" id="bannerInput" name="banner_toko" class="hidden" accept="image/*" onchange="previewImage(this, 'bannerPreview', 'bannerPlaceholder')">
                </div>

                {{-- DOKUMEN LEGALITAS --}}
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm">
                    <h3 class="text-sm font-black text-slate-800 mb-2 flex items-center gap-2">
                        <i class="mdi mdi-file-certificate text-amber-500"></i> Dokumen Bisnis
                    </h3>
                    <p class="text-[10px] font-bold text-slate-400 mb-4 uppercase tracking-tighter">Syarat untuk tender & official lencana</p>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[11px] font-black text-slate-700 mb-1">Nomor Induk Berusaha (NIB)</label>
                            <input type="file" name="dokumen_nib" class="w-full text-xs border border-slate-200 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none">
                            @if(!empty($toko->dokumen_nib)) <span class="text-[9px] text-emerald-600 font-bold"><i class="mdi mdi-check"></i> File NIB Tersimpan</span> @endif
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-slate-700 mb-1">NPWP Perusahaan/Pribadi</label>
                            <input type="file" name="dokumen_npwp" class="w-full text-xs border border-slate-200 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none">
                            @if(!empty($toko->dokumen_npwp)) <span class="text-[9px] text-emerald-600 font-bold"><i class="mdi mdi-check"></i> File NPWP Tersimpan</span> @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: IDENTITAS & MAPS --}}
            <div class="lg:col-span-8 space-y-6">

                {{-- INFORMASI DASAR --}}
                <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm">
                    <div class="bg-slate-50/80 px-6 py-4 border-b border-slate-100">
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Informasi Identitas</h3>
                    </div>
                    <div class="p-6 space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Toko Resmi *</label>
                                <input type="text" name="nama_toko" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-bold rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-blue-600 outline-none transition-all" value="{{ $toko->nama_toko ?? '' }}" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">WhatsApp Toko *</label>
                                <div class="flex border border-slate-200 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-blue-600 transition-all">
                                    <span class="bg-slate-100 px-4 py-3 text-slate-500 font-black border-r border-slate-200">+62</span>
                                    <input type="text" name="no_telepon" class="w-full bg-slate-50 px-4 py-3 text-sm font-bold outline-none" value="{{ ltrim($toko->telepon_toko ?? '', '0') }}" placeholder="8123xxx" required>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Slogan / Tagline</label>
                            <input type="text" name="slogan" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-semibold rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-blue-600 outline-none transition-all" value="{{ $toko->slogan ?? '' }}" placeholder="Cth: Supplier Semen Terlengkap Se-Jawa Barat">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Bisnis</label>
                            <textarea name="deskripsi_toko" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-medium rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-blue-600 outline-none min-h-[100px] resize-none">{{ $toko->deskripsi_toko ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- LOKASI PRESIPI PETA --}}
                <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm">
                    <div class="bg-slate-50/80 px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Titik Koordinat & Alamat</h3>
                        <div class="flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 border border-emerald-200 rounded-full text-[10px] font-black text-emerald-600">
                            <i class="mdi mdi-map-marker-radius"></i> SINKRONISASI PETA AKTIF
                        </div>
                    </div>
                    <div class="p-6 space-y-6">
                        {{-- SEARCH --}}
                        <div class="flex gap-2">
                            <input type="text" id="searchLokasi" class="flex-1 bg-slate-50 border border-slate-200 text-slate-900 text-sm font-bold rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-emerald-500 outline-none transition-all" placeholder="Cari lokasi: Nama Jalan, Kecamatan, atau Kota...">
                            <button type="button" onclick="cariLokasiMap()" class="bg-slate-800 hover:bg-slate-900 text-white px-6 py-3 rounded-xl text-sm font-bold transition-all shadow-md">
                                <i class="mdi mdi-magnify"></i> Cari
                            </button>
                        </div>

                        {{-- MAP --}}
                        <div id="map"></div>

                        {{-- ALAMAT OTOMATIS --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Kota / Kabupaten (Otomatis)</label>
                                <input type="text" name="kota" id="inputKota" class="w-full input-auto border border-slate-200 text-sm rounded-xl px-4 py-3 outline-none" value="{{ $toko->kota ?? '' }}" readonly required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Kode Pos (Otomatis)</label>
                                <input type="text" name="kode_pos" id="inputKodePos" class="w-full input-auto border border-slate-200 text-sm rounded-xl px-4 py-3 outline-none" value="{{ $toko->kode_pos ?? '' }}" readonly required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Detail & Patokan (Manual) *</label>
                            <textarea name="alamat_lengkap" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-medium rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-emerald-500 outline-none transition-all min-h-[80px] resize-none" placeholder="Contoh: Jl. Pasir Kaliki No. 10, Samping Gudang Baja Utama..." required>{{ $toko->alamat_toko ?? '' }}</textarea>
                            <p class="text-[10px] font-bold text-slate-400 mt-2 uppercase tracking-tighter italic">* Alamat ini adalah titik jemput logistik armada besar.</p>
                        </div>

                        {{-- HIDDEN COORDS --}}
                        <input type="hidden" name="latitude" id="latitude" value="{{ $toko->latitude ?? '-6.558935' }}">
                        <input type="hidden" name="longitude" id="longitude" value="{{ $toko->longitude ?? '107.763321' }}">
                    </div>
                </div>

                {{-- KEBIJAKAN B2B --}}
                <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm">
                    <div class="bg-slate-50/80 px-6 py-4 border-b border-slate-100 flex items-center gap-2">
                        <i class="mdi mdi-shield-account text-indigo-600 text-lg"></i>
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Ketentuan & Kebijakan Toko</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2 text-indigo-600">Catatan Khusus Pemesanan</label>
                                <textarea name="catatan_toko" class="w-full bg-indigo-50/30 border border-indigo-100 text-slate-900 text-sm font-medium rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-indigo-600 outline-none min-h-[120px] resize-none" placeholder="Contoh: Pesanan semen minimal 50 sak. Truk hanya masuk jalan aspal...">{{ $toko->catatan_toko ?? '' }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2 text-red-600">Kebijakan Retur Material</label>
                                <textarea name="kebijakan_retur" class="w-full bg-red-50/30 border border-red-100 text-slate-900 text-sm font-medium rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-red-600 outline-none min-h-[120px] resize-none" placeholder="Contoh: Semen cair/sudah mengeras tidak dapat dikembalikan. Besi yang dipotong tidak bisa retur...">{{ $toko->kebijakan_retur ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- STICKY SAVE BAR --}}
        <div class="fixed bottom-0 left-0 lg:left-[260px] right-0 bg-white/90 backdrop-blur-md border-t border-slate-200 px-6 py-4 flex items-center justify-between z-40 shadow-[0_-10px_15px_-3px_rgba(0,0,0,0.05)]">
            <div class="hidden sm:block">
                <p class="text-xs font-bold text-slate-500 m-0"><i class="mdi mdi-map-marker-check text-blue-500"></i> Pastikan titik peta sudah sesuai sebelum menyimpan.</p>
            </div>
            <button type="submit" id="btnSubmitProfile" class="w-full sm:w-auto px-10 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-2xl shadow-lg shadow-blue-500/30 transition-all flex items-center justify-center gap-3">
                <i class="mdi mdi-content-save-check text-xl"></i> SIMPAN PROFIL TOKO
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
{{-- SCRIPT LEAFLET --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');
    const kotaInput = document.getElementById('inputKota');
    const kodePosInput = document.getElementById('inputKodePos');
    
    let currentLat = parseFloat(latInput.value) || -6.558935;
    let currentLng = parseFloat(lngInput.value) || 107.763321;

    // 1. INISIALISASI PETA DENGAN FIX BUG
    const map = L.map('map', {
        center: [currentLat, currentLng],
        zoom: 15,
        fadeAnimation: false,
        zoomAnimation: false
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    const marker = L.marker([currentLat, currentLng], { draggable: true }).addTo(map);

    // Paksa peta refresh ukuran agar tidak pecah/abu-abu
    setTimeout(() => { map.invalidateSize(); }, 500);

    // 2. FUNGSI REVERSE GEOCODING (COORD -> ALAMAT)
    function fetchAddress(lat, lng) {
        kotaInput.value = "Menyesuaikan lokasi...";
        kodePosInput.value = "...";
        
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`)
            .then(res => res.json())
            .then(data => {
                if(data.address) {
                    const addr = data.address;
                    const city = addr.city || addr.town || addr.municipality || addr.county || addr.state_district || "";
                    kotaInput.value = city;
                    kodePosInput.value = addr.postcode || "";
                }
            })
            .catch(() => {
                kotaInput.value = "Gagal mengambil data";
            });
    }

    // 3. EVENT HANDLERS
    marker.on('dragend', function (e) {
        const p = e.target.getLatLng();
        latInput.value = p.lat.toFixed(8);
        lngInput.value = p.lng.toFixed(8);
        fetchAddress(p.lat, p.lng);
    });

    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        latInput.value = e.latlng.lat.toFixed(8);
        lngInput.value = e.latlng.lng.toFixed(8);
        fetchAddress(e.latlng.lat, e.latlng.lng);
    });

    function cariLokasiMap() {
        const query = document.getElementById('searchLokasi').value;
        if(query.length < 3) return alert('Ketik minimal 3 karakter');
        
        const btn = event.currentTarget;
        const original = btn.innerHTML;
        btn.innerHTML = '<i class="mdi mdi-loading mdi-spin"></i>';

        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => {
                btn.innerHTML = original;
                if(data.length > 0) {
                    const res = data[0];
                    map.setView([res.lat, res.lon], 16);
                    marker.setLatLng([res.lat, res.lon]);
                    latInput.value = parseFloat(res.lat).toFixed(8);
                    lngInput.value = parseFloat(res.lon).toFixed(8);
                    fetchAddress(res.lat, res.lon);
                } else {
                    Swal.fire({icon: 'error', title: 'Tidak Ditemukan', text: 'Coba nama daerah lain.', customClass: { popup: 'rounded-2xl' }});
                }
            });
    }

    // 4. PREVIEW GAMBAR
    function previewImage(input, previewId, placeholderId = null) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.getElementById(previewId);
                img.src = e.target.result;
                img.classList.remove('hidden');
                if(placeholderId) document.getElementById(placeholderId).classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // 5. SUBMIT STATE
    document.getElementById('profileForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmitProfile');
        btn.innerHTML = '<i class="mdi mdi-loading mdi-spin"></i> MEMPROSES...';
        btn.disabled = true;
    });

    // Jalankan awal jika data kosong
    if(kotaInput.value === '') { fetchAddress(currentLat, currentLng); }
</script>
@endpush