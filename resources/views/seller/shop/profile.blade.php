@extends('layouts.seller')

@section('title', 'Profil & Legalitas Toko')

@push('styles')
{{-- LEAFLET CSS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    
    /* Animasi Upload & Interaksi */
    .upload-hover { transition: all 0.3s ease; }
    .upload-hover:hover { border-color: #3b82f6; background-color: #eff6ff; }
    .upload-hover:hover .upload-overlay { opacity: 1; backdrop-filter: blur(2px); }
    
    /* FIX BUG PETA PECAH / GREY TILES */
    #map {
        width: 100% !important;
        height: 350px !important;
        border-radius: 1rem;
        border: 1px solid #e2e8f0;
        z-index: 10 !important;
    }
    
    /* Style Custom Dropzone Dokumen */
    .file-dropzone {
        border: 2px dashed #cbd5e1;
        border-radius: 1rem;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.2s ease;
        cursor: pointer;
        background: #f8fafc;
    }
    .file-dropzone:hover { border-color: #3b82f6; background: #eff6ff; }
    
    /* Input Auto Styling */
    .input-auto {
        background-color: #f1f5f9 !important;
        color: #64748b !important;
        cursor: not-allowed;
        font-weight: 600;
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
        <script>document.addEventListener('DOMContentLoaded', () => Toast.fire({icon: 'success', title: '{{ session("success") }}'}));</script>
    @endif
    @if($errors->any())
        <script>document.addEventListener('DOMContentLoaded', () => Toast.fire({icon: 'error', title: 'Periksa kembali form Anda!'}));</script>
    @endif

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-200">
                <i class="mdi mdi-store-cog-outline text-3xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Profil & Legalitas Toko</h1>
                <p class="text-sm font-medium text-slate-500 mt-0.5">Kelola identitas B2B, dokumen legal, dan titik jemput logistik armada.</p>
            </div>
        </div>
    </div>

    <form action="{{ route('seller.shop.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">

            {{-- KOLOM KIRI: VISUAL & DATA LEGAL --}}
            <div class="lg:col-span-4 space-y-6">

                {{-- LOGO & BANNER --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/60">
                    <h3 class="text-sm font-black text-slate-800 mb-5 flex items-center gap-2">
                        <i class="mdi mdi-image-multiple text-blue-500 text-lg"></i> Visual Branding
                    </h3>

                    {{-- Logo --}}
                    <div class="relative w-32 h-32 mx-auto rounded-full border-4 border-slate-50 shadow-md overflow-hidden group upload-hover mb-6" onclick="document.getElementById('logoInput').click()">
                        @php $logoUrl = !empty($toko->logo_toko) ? asset('assets/uploads/logos/'.$toko->logo_toko) : 'https://ui-avatars.com/api/?name='.urlencode($toko->nama_toko ?? 'Toko').'&background=e2e8f0&color=475569&size=200'; @endphp
                        <img id="logoPreview" src="{{ $logoUrl }}" class="w-full h-full object-cover">
                        <div class="upload-overlay absolute inset-0 bg-slate-900/60 flex flex-col items-center justify-center text-white opacity-0 transition-all duration-300">
                            <i class="mdi mdi-camera-plus text-2xl mb-1"></i>
                            <span class="text-[10px] font-bold tracking-wider uppercase">Ubah Logo</span>
                        </div>
                    </div>
                    <input type="file" id="logoInput" name="logo_toko" class="hidden" accept="image/jpeg,image/png,image/jpg" onchange="previewImage(this, 'logoPreview')">

                    {{-- Banner --}}
                    <label class="block text-xs font-bold text-slate-700 mb-2">Banner Toko (Opsional)</label>
                    <div class="relative w-full h-32 rounded-2xl border-2 border-dashed border-slate-200 overflow-hidden group upload-hover flex items-center justify-center" onclick="document.getElementById('bannerInput').click()">
                        @if(!empty($toko->banner_toko))
                            <img id="bannerPreview" src="{{ asset('assets/uploads/banners/'.$toko->banner_toko) }}" class="absolute inset-0 w-full h-full object-cover">
                        @else
                            <img id="bannerPreview" src="" class="absolute inset-0 w-full h-full object-cover hidden">
                            <div id="bannerPlaceholder" class="text-center text-slate-500">
                                <i class="mdi mdi-panorama-variant-outline text-3xl mb-1 text-slate-400"></i>
                                <div class="text-xs font-bold">Upload Banner</div>
                                <div class="text-[10px] text-slate-400 mt-1">Rekomendasi: 1200x300px (Maks 2MB)</div>
                            </div>
                        @endif
                        <div class="upload-overlay absolute inset-0 bg-slate-900/60 flex flex-col items-center justify-center text-white opacity-0 transition-all duration-300 z-20">
                            <i class="mdi mdi-image-edit-outline text-2xl"></i>
                        </div>
                    </div>
                    <input type="file" id="bannerInput" name="banner_toko" class="hidden" accept="image/jpeg,image/png,image/jpg" onchange="previewImage(this, 'bannerPreview', 'bannerPlaceholder')">
                </div>

                {{-- DOKUMEN LEGALITAS --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/60">
                    <div class="mb-5">
                        <h3 class="text-sm font-black text-slate-800 flex items-center gap-2">
                            <i class="mdi mdi-file-certificate-outline text-amber-500 text-lg"></i> Dokumen Bisnis
                        </h3>
                        <p class="text-[11px] font-medium text-slate-500 mt-1">Syarat wajib untuk mengikuti tender & mendapatkan lencana <span class="font-bold text-blue-600">Official Store</span>.</p>
                    </div>

                    <div class="space-y-4">
                        {{-- NIB --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2">Nomor Induk Berusaha (NIB) *</label>
                            <div class="file-dropzone" onclick="document.getElementById('nibInput').click()">
                                <input type="file" id="nibInput" name="dokumen_nib" class="hidden" accept=".pdf,.jpg,.jpeg,.png" onchange="updateFileName(this, 'nibName')">
                                <i class="mdi mdi-cloud-upload-outline text-2xl text-slate-400 mb-1"></i>
                                <div id="nibName" class="text-xs font-bold text-slate-600">
                                    @if(!empty($toko->dokumen_nib)) 
                                        <span class="text-emerald-600"><i class="mdi mdi-check-circle"></i> {{ $toko->dokumen_nib }}</span>
                                    @else 
                                        Klik untuk upload PDF/JPG 
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- NPWP --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2">NPWP Perusahaan / Pribadi *</label>
                            <div class="file-dropzone" onclick="document.getElementById('npwpInput').click()">
                                <input type="file" id="npwpInput" name="dokumen_npwp" class="hidden" accept=".pdf,.jpg,.jpeg,.png" onchange="updateFileName(this, 'npwpName')">
                                <i class="mdi mdi-cloud-upload-outline text-2xl text-slate-400 mb-1"></i>
                                <div id="npwpName" class="text-xs font-bold text-slate-600">
                                    @if(!empty($toko->dokumen_npwp)) 
                                        <span class="text-emerald-600"><i class="mdi mdi-check-circle"></i> {{ $toko->dokumen_npwp }}</span>
                                    @else 
                                        Klik untuk upload PDF/JPG 
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: IDENTITAS & MAPS --}}
            <div class="lg:col-span-8 space-y-6">

                {{-- INFORMASI DASAR --}}
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-200/60">
                    <div class="bg-slate-50/80 px-6 py-4 border-b border-slate-100">
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Informasi Identitas</h3>
                    </div>
                    <div class="p-6 space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Toko Resmi <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_toko" class="w-full bg-white border border-slate-300 text-slate-900 text-sm font-semibold rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" value="{{ $toko->nama_toko ?? '' }}" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">WhatsApp Admin Toko <span class="text-red-500">*</span></label>
                                <div class="flex border border-slate-300 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all bg-white">
                                    <span class="bg-slate-100 px-4 py-3 text-slate-600 font-bold border-r border-slate-200">+62</span>
                                    <input type="number" name="no_telepon" class="w-full px-4 py-3 text-sm font-semibold outline-none bg-transparent" value="{{ ltrim($toko->telepon_toko ?? '', '0') }}" placeholder="8123456xxxx" required>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Slogan / Tagline Bisnis</label>
                            <input type="text" name="slogan" class="w-full bg-white border border-slate-300 text-slate-900 text-sm font-semibold rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" value="{{ $toko->slogan ?? '' }}" placeholder="Cth: Supplier Material Konstruksi Terlengkap di Jawa Barat">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Lengkap Toko</label>
                            <textarea name="deskripsi_toko" class="w-full bg-white border border-slate-300 text-slate-900 text-sm leading-relaxed font-medium rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none min-h-[120px] resize-none" placeholder="Ceritakan sejarah toko, keunggulan, dan jenis material yang Anda jual...">{{ $toko->deskripsi_toko ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- LOKASI & PETA (SUDAH DIKOREKSI LOGIKANYA) --}}
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-200/60">
                    <div class="bg-slate-50/80 px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Alamat & Titik Jemput Logistik</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        
                        {{-- INFO PENTING UNTUK USER --}}
                        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex gap-3">
                            <i class="mdi mdi-information text-blue-600 text-xl"></i>
                            <div class="text-sm text-blue-800">
                                <p class="font-bold mb-1">Panduan Pengaturan Lokasi:</p>
                                <ul class="list-disc pl-4 space-y-1 text-xs font-medium">
                                    <li><strong>Dropdown Alamat</strong> digunakan untuk menghitung ongkos kirim reguler (JNE, Cargo, dll).</li>
                                    <li><strong>Titik Peta (Pin)</strong> digunakan untuk rute kurir toko / armada berat (Truk Pasir, Pick Up).</li>
                                </ul>
                            </div>
                        </div>

                        {{-- DROPDOWN WILAYAH (SANGAT DISARANKAN MENGGUNAKAN SELECT2 & AJAX KE DATABASE PROVINSI) --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Provinsi <span class="text-red-500">*</span></label>
                                {{-- GANTI DENGAN SELECT YANG MENGAMBIL DARI $provinces --}}
                                <select name="province_id" class="w-full bg-white border border-slate-300 text-sm font-semibold rounded-xl px-4 py-3 outline-none" required>
                                    <option value="">Pilih Provinsi</option>
                                    <option value="2" selected>JAWA BARAT</option> {{-- Dummy Default berdasarkan DB --}}
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Kabupaten/Kota <span class="text-red-500">*</span></label>
                                <select name="city_id" class="w-full bg-white border border-slate-300 text-sm font-semibold rounded-xl px-4 py-3 outline-none" required>
                                    <option value="21" selected>KABUPATEN SUBANG</option> {{-- Dummy --}}
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Kecamatan <span class="text-red-500">*</span></label>
                                <select name="district_id" class="w-full bg-white border border-slate-300 text-sm font-semibold rounded-xl px-4 py-3 outline-none" required>
                                    <option value="215" selected>Pagaden</option> {{-- Dummy --}}
                                </select>
                            </div>
                        </div>

                        <hr class="border-slate-200">

                        {{-- SEARCH PETA --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Geser Pin Peta Sesuai Lokasi Gudang/Toko</label>
                            <div class="flex gap-2 mb-3">
                                <div class="relative flex-1">
                                    <i class="mdi mdi-map-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                    <input type="text" id="searchLokasi" class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm font-semibold rounded-xl pl-11 pr-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none transition-all" placeholder="Cari nama jalan atau area di peta...">
                                </div>
                                <button type="button" onclick="cariLokasiMap()" class="bg-slate-800 hover:bg-slate-900 text-white px-6 py-3 rounded-xl text-sm font-bold transition-all shadow-md">
                                    Cari
                                </button>
                            </div>
                            
                            {{-- MAP CONTAINER --}}
                            <div class="relative rounded-2xl overflow-hidden shadow-inner">
                                <div id="map"></div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Detail & Patokan <span class="text-red-500">*</span></label>
                            <textarea name="alamat_toko" class="w-full bg-white border border-slate-300 text-slate-900 text-sm font-medium rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none transition-all min-h-[80px] resize-none" placeholder="Cth: Jl. Raya Pantura No. 45. Gudang warna biru, pagar hitam. Samping Pom Bensin." required>{{ $toko->alamat_toko ?? '' }}</textarea>
                        </div>

                        {{-- HIDDEN COORDS UNTUK DATABASE --}}
                        <input type="hidden" name="latitude" id="latitude" value="{{ $toko->latitude ?? '-6.558935' }}">
                        <input type="hidden" name="longitude" id="longitude" value="{{ $toko->longitude ?? '107.763321' }}">
                    </div>
                </div>

                {{-- KEBIJAKAN B2B --}}
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-200/60">
                    <div class="bg-slate-50/80 px-6 py-4 border-b border-slate-100 flex items-center gap-2">
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Ketentuan & Kebijakan Toko</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-indigo-700 mb-2">Catatan Khusus Pemesanan</label>
                                <textarea name="catatan_toko" class="w-full bg-indigo-50/30 border border-indigo-200 text-slate-900 text-sm font-medium rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 outline-none min-h-[120px] resize-none" placeholder="Contoh: Pesanan semen minimal 50 sak. Armada truk pembeli harus bak terbuka...">{{ $toko->catatan_toko ?? '' }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-red-700 mb-2">Kebijakan Retur Material</label>
                                <textarea name="kebijakan_retur" class="w-full bg-red-50/30 border border-red-200 text-slate-900 text-sm font-medium rounded-xl px-4 py-3 focus:ring-2 focus:ring-red-500 outline-none min-h-[120px] resize-none" placeholder="Contoh: Batas waktu komplain 1x24 jam. Besi yang sudah dipotong custom tidak bisa dikembalikan...">{{ $toko->kebijakan_retur ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- STICKY SAVE BAR --}}
        <div class="fixed bottom-0 left-0 lg:left-[260px] right-0 bg-white/95 backdrop-blur-sm border-t border-slate-200 px-6 py-4 flex items-center justify-between z-40 shadow-[0_-10px_20px_-5px_rgba(0,0,0,0.05)]">
            <div class="hidden sm:flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
                    <i class="mdi mdi-shield-check"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-700 m-0">Pastikan data sudah benar.</p>
                    <p class="text-[10px] text-slate-500">Perubahan legalitas mungkin membutuhkan review Admin.</p>
                </div>
            </div>
            <button type="submit" id="btnSubmitProfile" class="w-full sm:w-auto px-10 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-xl shadow-lg shadow-blue-500/30 transition-all flex items-center justify-center gap-3">
                <i class="mdi mdi-content-save-check text-xl"></i> SIMPAN PERUBAHAN
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
{{-- SCRIPT LEAFLET --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');

        let currentLat = parseFloat(latInput.value) || -6.558935;
        let currentLng = parseFloat(lngInput.value) || 107.763321;

        // 1. INISIALISASI PETA
        const map = L.map('map').setView([currentLat, currentLng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Custom Marker Icon yang lebih profesional
        const customIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        const marker = L.marker([currentLat, currentLng], { draggable: true, icon: customIcon }).addTo(map);

        // SOLUSI TERBAIK UNTUK BUG GREY TILES LEAFLET
        setTimeout(function() {
            map.invalidateSize();
        }, 300);

        // 2. EVENT HANDLERS MARKER
        marker.on('dragend', function (e) {
            const p = e.target.getLatLng();
            latInput.value = p.lat.toFixed(8);
            lngInput.value = p.lng.toFixed(8);
        });

        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            latInput.value = e.latlng.lat.toFixed(8);
            lngInput.value = e.latlng.lng.toFixed(8);
        });

        // 3. FUNGSI PENCARIAN PETA
        window.cariLokasiMap = function() {
            const query = document.getElementById('searchLokasi').value;
            if(query.length < 3) {
                Toast.fire({icon: 'warning', title: 'Ketik minimal 3 karakter untuk mencari'});
                return;
            }

            const btn = event.currentTarget;
            const original = btn.innerHTML;
            btn.innerHTML = '<i class="mdi mdi-loading mdi-spin"></i>';
            btn.disabled = true;

            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    btn.innerHTML = original;
                    btn.disabled = false;
                    
                    if(data.length > 0) {
                        const res = data[0];
                        map.setView([res.lat, res.lon], 16);
                        marker.setLatLng([res.lat, res.lon]);
                        latInput.value = parseFloat(res.lat).toFixed(8);
                        lngInput.value = parseFloat(res.lon).toFixed(8);
                    } else {
                        Toast.fire({icon: 'error', title: 'Lokasi tidak ditemukan di peta'});
                    }
                })
                .catch(() => {
                    btn.innerHTML = original;
                    btn.disabled = false;
                    Toast.fire({icon: 'error', title: 'Terjadi kesalahan jaringan'});
                });
        }
    });

    // 4. PREVIEW IMAGE (Logo & Banner)
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

    // 5. UPDATE NAMA FILE (NIB/NPWP)
    function updateFileName(input, targetId) {
        if(input.files && input.files.length > 0) {
            const fileName = input.files[0].name;
            document.getElementById(targetId).innerHTML = `<span class="text-blue-600"><i class="mdi mdi-check-circle"></i> File terpilih: ${fileName}</span>`;
        }
    }

    // 6. LOADING STATE SAAT SUBMIT
    document.getElementById('profileForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmitProfile');
        btn.innerHTML = '<i class="mdi mdi-loading mdi-spin text-xl"></i> MENYIMPAN DATA...';
        btn.classList.add('opacity-75', 'cursor-not-allowed');
        btn.disabled = true;
    });
</script>
@endpush