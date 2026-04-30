@extends('layouts.seller')

@section('title', 'Profil & Legalitas Toko')

@push('styles')
{{-- LEAFLET CSS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    .upload-hover:hover .upload-overlay { opacity: 1; }

    /* FIX BUG PETA PECAH / GREY TILES */
    #map {
        width: 100% !important;
        height: 450px !important;
        border-radius: 1.5rem;
        border: 2px solid #e2e8f0;
        z-index: 1 !important;
    }
    .leaflet-tile-container img { width: 256.5px !important; height: 256.5px !important; }

    .input-auto {
        background-color: #f8fafc !important;
        color: #1e293b !important;
        cursor: not-allowed;
        border-color: #e2e8f0 !important;
        font-weight: 700;
    }
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
            <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg">
                <i class="mdi mdi-store-check text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Profil Bisnis & Lokasi Gudang</h1>
                <p class="text-sm font-medium text-slate-500 mt-0.5">Lengkapi koordinat titik jemput untuk armada logistik berat.</p>
            </div>
        </div>
    </div>

    <form action="{{ route('seller.shop.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            {{-- KOLOM KIRI --}}
            <div class="lg:col-span-4 space-y-6">
                {{-- VISUAL BRANDING --}}
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm">
                    <h3 class="text-sm font-black text-slate-800 mb-6 flex items-center gap-2">
                        <i class="mdi mdi-image-multiple text-blue-500"></i> Visual Branding
                    </h3>
                    <div class="relative w-32 h-32 mx-auto rounded-3xl border-4 border-slate-50 shadow-md overflow-hidden group upload-hover cursor-pointer mb-6" onclick="document.getElementById('logoInput').click()">
                        @php $logoUrl = !empty($toko->logo_toko) ? asset('assets/uploads/logos/'.$toko->logo_toko) : 'https://placehold.co/200x200?text=Logo'; @endphp
                        <img id="logoPreview" src="{{ $logoUrl }}" class="w-full h-full object-cover">
                        <div class="upload-overlay absolute inset-0 bg-slate-900/50 flex flex-col items-center justify-center text-white opacity-0 transition-opacity">
                            <i class="mdi mdi-camera text-2xl"></i>
                        </div>
                    </div>
                    <input type="file" id="logoInput" name="logo_toko" class="hidden" accept="image/*" onchange="previewImage(this, 'logoPreview')">

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
                    </div>
                    <input type="file" id="bannerInput" name="banner_toko" class="hidden" accept="image/*" onchange="previewImage(this, 'bannerPreview', 'bannerPlaceholder')">
                </div>

                {{-- DOKUMEN --}}
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm text-slate-400">
                    <h3 class="text-sm font-black text-slate-800 mb-2 flex items-center gap-2">
                        <i class="mdi mdi-file-certificate text-amber-500"></i> Legalitas B2B
                    </h3>
                    <div class="space-y-4 mt-4">
                        <div>
                            <label class="block text-[11px] font-black text-slate-700 mb-1 uppercase">File NIB</label>
                            <input type="file" name="dokumen_nib" class="w-full text-xs border rounded-lg p-2">
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-slate-700 mb-1 uppercase">File NPWP</label>
                            <input type="file" name="dokumen_npwp" class="w-full text-xs border rounded-lg p-2">
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN --}}
            <div class="lg:col-span-8 space-y-6">
                {{-- PETA & LOKASI PRESISI --}}
                <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm">
                    <div class="bg-slate-50/80 px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest"><i class="mdi mdi-map-marker-radius text-emerald-500 mr-2"></i> Lokasi Gudang Material</h3>
                        <button type="button" onclick="getLocation()" class="bg-blue-50 text-blue-600 border border-blue-100 px-3 py-1.5 rounded-xl text-[10px] font-black uppercase hover:bg-blue-600 hover:text-white transition-all">
                            <i class="mdi mdi-crosshairs-gps"></i> Gunakan Lokasi Saya
                        </button>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="flex gap-2">
                            <input type="text" id="searchLokasi" class="flex-1 bg-slate-50 border border-slate-200 text-slate-900 text-sm font-bold rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-emerald-500 outline-none" placeholder="Cari kecamatan atau nama jalan...">
                            <button type="button" onclick="cariLokasiMap()" class="bg-slate-800 hover:bg-slate-900 text-white px-6 py-3 rounded-xl text-sm font-bold shadow-md transition-all">Cari</button>
                        </div>

                        <div id="map"></div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Kabupaten / Kota (Auto)</label>
                                <input type="text" name="kota" id="inputKota" class="w-full input-auto border border-slate-200 text-sm rounded-xl px-4 py-3 outline-none" value="{{ $toko->kota ?? '' }}" readonly required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Kode Pos (Auto)</label>
                                <input type="text" name="kode_pos" id="inputKodePos" class="w-full input-auto border border-slate-200 text-sm rounded-xl px-4 py-3 outline-none" value="{{ $toko->kode_pos ?? '' }}" readonly required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2 text-blue-600">Alamat Lengkap Gudang (Detail Patokan) *</label>
                            <textarea name="alamat_lengkap" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-medium rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-600 outline-none min-h-[100px] resize-none" placeholder="Cth: Komplek Pergudangan A, Blok B No 5. Patokan: Sebelah Pom Bensin." required>{{ $toko->alamat_toko ?? '' }}</textarea>
                        </div>

                        <input type="hidden" name="latitude" id="latitude" value="{{ $toko->latitude ?? '-6.558935' }}">
                        <input type="hidden" name="longitude" id="longitude" value="{{ $toko->longitude ?? '107.763321' }}">
                    </div>
                </div>

                {{-- DATA IDENTITAS --}}
                <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm">
                    <div class="bg-slate-50/80 px-6 py-4 border-b border-slate-100 flex items-center gap-2">
                        <i class="mdi mdi-store-edit text-blue-600 text-lg"></i>
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Identitas Bisnis</h3>
                    </div>
                    <div class="p-6 space-y-5">
                        <div>
                            <label class="block text-sm font-bold text-zinc-700 mb-2">Nama Toko *</label>
                            <input type="text" name="nama_toko" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-bold rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-600 outline-none" value="{{ $toko->nama_toko ?? '' }}" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-zinc-700 mb-2">Slogan Bisnis</label>
                            <input type="text" name="slogan" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-semibold rounded-xl px-4 py-3 outline-none" value="{{ $toko->slogan ?? '' }}" placeholder="Supplier Besi & Baja Ringan Terpercaya">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- STICKY SAVE --}}
        <div class="fixed bottom-0 left-0 lg:left-[260px] right-0 bg-white/95 backdrop-blur-md border-t border-slate-200 px-6 py-4 flex items-center justify-end z-40">
            <button type="submit" id="btnSubmitProfile" class="px-10 py-3 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-xl shadow-lg transition-all flex items-center gap-2">
                <i class="mdi mdi-content-save-check"></i> SIMPAN PROFIL BISNIS
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');
    const kotaInput = document.getElementById('inputKota');
    const kodePosInput = document.getElementById('inputKodePos');

    // 1. INISIALISASI PETA
    const map = L.map('map', {
        center: [parseFloat(latInput.value), parseFloat(lngInput.value)],
        zoom: 15,
        fadeAnimation: false
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);
    const marker = L.marker([parseFloat(latInput.value), parseFloat(lngInput.value)], { draggable: true }).addTo(map);

    // Refresh size fix bug grey tiles[cite: 1]
    setTimeout(() => { map.invalidateSize(); }, 500);

    // 2. FUNGSI GPS (LOKASI TERKINI)
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                updateMap(lat, lng);
            }, () => {
                alert("Gagal mengakses lokasi GPS Anda.");
            });
        } else {
            alert("Browser tidak mendukung GPS.");
        }
    }

    // 3. REVERSE GEOCODING
    function updateAddress(lat, lng) {
        kotaInput.value = "Menentukan...";
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18`)
            .then(res => res.json())
            .then(data => {
                if(data.address) {
                    const addr = data.address;
                    kotaInput.value = addr.city || addr.town || addr.county || addr.state_district || "";
                    kodePosInput.value = addr.postcode || "";
                }
            });
    }

    function updateMap(lat, lng) {
        const newLatLng = new L.LatLng(lat, lng);
        marker.setLatLng(newLatLng);
        map.setView(newLatLng, 16);
        latInput.value = lat.toFixed(8);
        lngInput.value = lng.toFixed(8);
        updateAddress(lat, lng);
    }

    // 4. EVENT HANDLERS
    marker.on('dragend', function (e) {
        const p = e.target.getLatLng();
        updateMap(p.lat, p.lng);
    });

    map.on('click', function(e) {
        updateMap(e.latlng.lat, e.latlng.lng);
    });

    function cariLokasiMap() {
        const q = document.getElementById('searchLokasi').value;
        if(q.length < 3) return;
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(q)}`)
            .then(res => res.json())
            .then(data => {
                if(data.length > 0) updateMap(parseFloat(data[0].lat), parseFloat(data[0].lon));
            });
    }

    // 5. OTHERS
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

    document.getElementById('profileForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmitProfile');
        btn.innerHTML = '<i class="mdi mdi-loading mdi-spin"></i> PROSES...';
        btn.disabled = true;
    });

    if(kotaInput.value === '') { fetchAddress(parseFloat(latInput.value), parseFloat(lngInput.value)); }
</script>
@endpush
