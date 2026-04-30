@extends('layouts.seller')

@section('title', 'Profil & Legalitas Toko')

@push('styles')
{{-- LEAFLET CSS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    /* HIDE SCROLLBAR BUT KEEP FUNCTIONALITY */
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    /* LEAFLET Z-INDEX FIX (Agar tidak menimpa sticky bar / dropdown) */
    .leaflet-container {
        z-index: 1 !important;
        font-family: inherit;
    }

    /* CUSTOM ANIMATIONS & STATES */
    .glass-effect {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }

    .upload-overlay { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
    .group:hover .upload-overlay { opacity: 1; }

    .dropzone-active {
        border-color: #3b82f6 !important;
        background-color: #eff6ff !important;
        transform: scale(1.02);
    }

    /* SMOOTH INPUT TRANSITIONS */
    .input-premium {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ANIMASI GPS BUTTON */
    @keyframes pulse-ring {
        0% { transform: scale(0.8); box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(59, 130, 246, 0); }
        100% { transform: scale(0.8); box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
    }
    .gps-active .mdi-crosshairs-gps {
        animation: pulse-ring 2s infinite;
        color: #3b82f6;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-[#f8fafc] p-4 md:p-6 lg:p-8 font-sans text-slate-800 pb-36">

    {{-- SWEETALERT SETUP --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true, position: 'top-end', showConfirmButton: false, timer: 4000,
            timerProgressBar: true, customClass: { popup: 'rounded-2xl shadow-xl border border-slate-100 font-sans' }
        });
        @if(session('success')) document.addEventListener('DOMContentLoaded', () => Toast.fire({icon: 'success', title: '{{ session("success") }}'})); @endif
        @if($errors->any()) document.addEventListener('DOMContentLoaded', () => Toast.fire({icon: 'error', title: 'Terjadi kesalahan, periksa form Anda!'})); @endif
    </script>

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 relative z-10">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center text-white shadow-[0_8px_30px_rgb(59,130,246,0.3)]">
                <i class="mdi mdi-store-cog-outline text-3xl"></i>
            </div>
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Profil & Legalitas</h1>
                <p class="text-sm font-semibold text-slate-500 mt-1">Kelola identitas, dokumen B2B, dan presisi titik logistik.</p>
            </div>
        </div>
    </div>

    <form action="{{ route('seller.shop.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 relative z-10">

            {{-- KOLOM KIRI: VISUAL & DATA LEGAL --}}
            <div class="lg:col-span-4 space-y-8">

                {{-- VISUAL BRANDING --}}
                <div class="bg-white rounded-[2rem] p-7 shadow-[0_2px_20px_rgba(0,0,0,0.02)] border border-slate-100 transition-all duration-300 hover:shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                            <i class="mdi mdi-palette-swatch text-xl"></i>
                        </div>
                        <h3 class="text-base font-bold text-slate-800">Visual Branding</h3>
                    </div>

                    {{-- Logo --}}
                    <div class="relative w-36 h-36 mx-auto rounded-full shadow-lg border-4 border-white overflow-hidden group cursor-pointer mb-8 ring-1 ring-slate-200" onclick="document.getElementById('logoInput').click()">
                        @php $logoUrl = !empty($toko->logo_toko) ? asset('assets/uploads/logos/'.$toko->logo_toko) : 'https://ui-avatars.com/api/?name='.urlencode($toko->nama_toko ?? 'Toko').'&background=f1f5f9&color=475569&size=300'; @endphp
                        <img id="logoPreview" src="{{ $logoUrl }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="upload-overlay absolute inset-0 bg-slate-900/60 backdrop-blur-sm flex flex-col items-center justify-center text-white opacity-0">
                            <i class="mdi mdi-camera-plus text-3xl mb-1 transform -translate-y-2 group-hover:translate-y-0 transition-transform duration-300"></i>
                            <span class="text-xs font-bold tracking-widest uppercase">Ubah Logo</span>
                        </div>
                    </div>
                    <input type="file" id="logoInput" name="logo_toko" class="hidden" accept="image/jpeg,image/png,image/jpg" onchange="previewImage(this, 'logoPreview')">

                    {{-- Banner --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Banner Toko (Opsional)</label>
                        <div class="relative w-full h-36 rounded-2xl border-2 border-dashed border-slate-200 overflow-hidden group cursor-pointer flex items-center justify-center bg-slate-50 hover:bg-blue-50 hover:border-blue-300 transition-colors" onclick="document.getElementById('bannerInput').click()">
                            @if(!empty($toko->banner_toko))
                                <img id="bannerPreview" src="{{ asset('assets/uploads/banners/'.$toko->banner_toko) }}" class="absolute inset-0 w-full h-full object-cover">
                            @else
                                <img id="bannerPreview" src="" class="absolute inset-0 w-full h-full object-cover hidden">
                                <div id="bannerPlaceholder" class="text-center text-slate-400 group-hover:text-blue-500 transition-colors">
                                    <i class="mdi mdi-panorama-variant-outline text-4xl mb-2"></i>
                                    <div class="text-sm font-bold">Upload Banner</div>
                                    <div class="text-xs font-medium mt-1 opacity-70">1200 x 300px (Max 2MB)</div>
                                </div>
                            @endif
                            <div class="upload-overlay absolute inset-0 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center text-white opacity-0">
                                <i class="mdi mdi-image-edit-outline text-3xl"></i>
                            </div>
                        </div>
                        <input type="file" id="bannerInput" name="banner_toko" class="hidden" accept="image/jpeg,image/png,image/jpg" onchange="previewImage(this, 'bannerPreview', 'bannerPlaceholder')">
                    </div>
                </div>

                {{-- DOKUMEN LEGALITAS (DRAG & DROP) --}}
                <div class="bg-white rounded-[2rem] p-7 shadow-[0_2px_20px_rgba(0,0,0,0.02)] border border-slate-100">
                    <div class="mb-6">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500">
                                <i class="mdi mdi-file-certificate-outline text-xl"></i>
                            </div>
                            <h3 class="text-base font-bold text-slate-800">Dokumen Bisnis</h3>
                        </div>
                        <p class="text-xs font-medium text-slate-500 leading-relaxed">Syarat wajib untuk verifikasi B2B dan lencana <span class="text-blue-600 font-bold bg-blue-50 px-2 py-0.5 rounded-md">Official Store</span>.</p>
                    </div>

                    <div class="space-y-5">
                        {{-- NIB --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Dokumen NIB *</label>
                            <div id="dropzoneNIB" class="file-dropzone border-2 border-dashed border-slate-200 rounded-2xl p-5 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-all duration-300 relative overflow-hidden" onclick="document.getElementById('nibInput').click()">
                                <input type="file" id="nibInput" name="dokumen_nib" class="hidden absolute inset-0" accept=".pdf,.jpg,.jpeg,.png" onchange="updateFileName(this, 'nibName', 'dropzoneNIB')">
                                <div class="relative z-10 flex flex-col items-center justify-center pointer-events-none">
                                    <i class="mdi mdi-cloud-upload-outline text-3xl text-slate-400 mb-2 drop-icon"></i>
                                    <div id="nibName" class="text-sm font-semibold text-slate-600">
                                        @if(!empty($toko->dokumen_nib))
                                            <span class="text-emerald-600 flex items-center gap-1 justify-center"><i class="mdi mdi-check-decagram"></i> {{ $toko->dokumen_nib }}</span>
                                        @else
                                            Drag & drop atau klik disini
                                        @endif
                                    </div>
                                    <div class="text-[10px] text-slate-400 mt-1">PDF / JPG Max 5MB</div>
                                </div>
                            </div>
                        </div>

                        {{-- NPWP --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Dokumen NPWP *</label>
                            <div id="dropzoneNPWP" class="file-dropzone border-2 border-dashed border-slate-200 rounded-2xl p-5 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-all duration-300 relative overflow-hidden" onclick="document.getElementById('npwpInput').click()">
                                <input type="file" id="npwpInput" name="dokumen_npwp" class="hidden absolute inset-0" accept=".pdf,.jpg,.jpeg,.png" onchange="updateFileName(this, 'npwpName', 'dropzoneNPWP')">
                                <div class="relative z-10 flex flex-col items-center justify-center pointer-events-none">
                                    <i class="mdi mdi-cloud-upload-outline text-3xl text-slate-400 mb-2 drop-icon"></i>
                                    <div id="npwpName" class="text-sm font-semibold text-slate-600">
                                        @if(!empty($toko->dokumen_npwp))
                                            <span class="text-emerald-600 flex items-center gap-1 justify-center"><i class="mdi mdi-check-decagram"></i> {{ $toko->dokumen_npwp }}</span>
                                        @else
                                            Drag & drop atau klik disini
                                        @endif
                                    </div>
                                    <div class="text-[10px] text-slate-400 mt-1">PDF / JPG Max 5MB</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: IDENTITAS & MAPS --}}
            <div class="lg:col-span-8 space-y-8">

                {{-- INFORMASI DASAR --}}
                <div class="bg-white rounded-[2rem] p-7 shadow-[0_2px_20px_rgba(0,0,0,0.02)] border border-slate-100">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                            <i class="mdi mdi-card-account-details-outline text-xl"></i>
                        </div>
                        <h3 class="text-base font-bold text-slate-800">Informasi Identitas</h3>
                    </div>

                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Toko Resmi <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_toko" class="input-premium w-full bg-slate-50/50 border border-slate-200 text-slate-900 text-sm font-bold rounded-xl px-4 py-3.5 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none" value="{{ $toko->nama_toko ?? '' }}" required>
                            </div>
                            <div class="group">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">WhatsApp Admin <span class="text-red-500">*</span></label>
                                <div class="flex border border-slate-200 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500/20 focus-within:border-indigo-500 focus-within:bg-white bg-slate-50/50 transition-all">
                                    <span class="bg-slate-100 px-4 py-3.5 text-slate-500 font-bold border-r border-slate-200 flex items-center">+62</span>
                                    <input type="number" name="no_telepon" class="input-premium w-full px-4 py-3.5 text-sm font-bold outline-none bg-transparent" value="{{ ltrim($toko->telepon_toko ?? '', '0') }}" placeholder="8123456xxxx" required>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Slogan / Tagline Bisnis</label>
                            <input type="text" name="slogan" class="input-premium w-full bg-slate-50/50 border border-slate-200 text-slate-900 text-sm font-bold rounded-xl px-4 py-3.5 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none" value="{{ $toko->slogan ?? '' }}" placeholder="Cth: Solusi Material Konstruksi Terbaik & Terpercaya">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deskripsi Lengkap Toko</label>
                            <textarea name="deskripsi_toko" class="input-premium w-full bg-slate-50/50 border border-slate-200 text-slate-900 text-sm leading-relaxed font-medium rounded-xl px-4 py-4 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none min-h-[140px] resize-none" placeholder="Ceritakan sejarah, keunggulan, dan detail layanan armada pengiriman Anda...">{{ $toko->deskripsi_toko ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- LOKASI & PETA --}}
                <div class="bg-white rounded-[2rem] p-7 shadow-[0_2px_20px_rgba(0,0,0,0.02)] border border-slate-100">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                                <i class="mdi mdi-map-marker-radius-outline text-xl"></i>
                            </div>
                            <h3 class="text-base font-bold text-slate-800">Alamat & Titik Koordinat</h3>
                        </div>
                    </div>

                    <div class="space-y-6">
                        {{-- INFO PANDUAN PETA --}}
                        <div class="bg-emerald-50/50 border border-emerald-100 rounded-2xl p-4 flex gap-4">
                            <i class="mdi mdi-information-outline text-emerald-600 text-2xl shrink-0"></i>
                            <div>
                                <p class="text-sm font-bold text-emerald-800 mb-1">Panduan Pengaturan Lokasi</p>
                                <p class="text-xs font-medium text-emerald-700/80 leading-relaxed">
                                    Dropdown wilayah digunakan API Ongkir (JNE, dll). <br>
                                    Peta/Pin digunakan khusus untuk Armada Berat Toko. Jika Pin digeser, kolom detail alamat akan terisi otomatis.
                                </p>
                            </div>
                        </div>

                        {{-- DROPDOWN WILAYAH (API ONGKIR) --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Provinsi <span class="text-red-500">*</span></label>
                                <select name="province_id" class="input-premium w-full bg-slate-50/50 border border-slate-200 text-sm font-bold rounded-xl px-4 py-3.5 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none appearance-none" required>
                                    <option value="">Pilih Provinsi</option>
                                    <option value="2" selected>JAWA BARAT</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kota/Kabupaten <span class="text-red-500">*</span></label>
                                <select name="city_id" class="input-premium w-full bg-slate-50/50 border border-slate-200 text-sm font-bold rounded-xl px-4 py-3.5 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none appearance-none" required>
                                    <option value="21" selected>KABUPATEN SUBANG</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kecamatan <span class="text-red-500">*</span></label>
                                <select name="district_id" class="input-premium w-full bg-slate-50/50 border border-slate-200 text-sm font-bold rounded-xl px-4 py-3.5 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none appearance-none" required>
                                    <option value="215" selected>Pagaden</option>
                                </select>
                            </div>
                        </div>

                        <hr class="border-slate-100 my-2">

                        {{-- SEARCH PETA --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Cari & Sesuaikan Pin Peta</label>
                            <div class="flex gap-2 mb-4">
                                <div class="relative flex-1">
                                    <i class="mdi mdi-magnify absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl"></i>
                                    <input type="text" id="searchLokasi" class="input-premium w-full bg-slate-50/50 border border-slate-200 text-slate-900 text-sm font-bold rounded-xl pl-12 pr-4 py-3.5 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none" placeholder="Ketik nama jalan atau patokan..." onkeydown="if(event.key === 'Enter'){ event.preventDefault(); cariLokasiMap(); }">
                                </div>
                                <button type="button" onclick="cariLokasiMap()" id="btnSearchMap" class="bg-slate-800 hover:bg-slate-900 text-white px-8 py-3.5 rounded-xl text-sm font-bold transition-all shadow-md shadow-slate-200">
                                    Cari
                                </button>
                            </div>

                            {{-- MAP CONTAINER - THE GOD TIER FIX --}}
                            <div class="relative w-full h-[400px] rounded-2xl overflow-hidden shadow-inner border border-slate-300 z-10 bg-slate-100">
                                <div id="map" class="w-full h-full"></div>

                                {{-- GPS BUTTON OVERLAY --}}
                                <button type="button" onclick="getLocation()" id="btnGps" class="absolute bottom-6 right-4 z-[400] bg-white text-slate-700 p-3 rounded-full shadow-[0_4px_15px_rgba(0,0,0,0.15)] hover:text-blue-600 hover:bg-blue-50 transition-all border border-slate-100 flex items-center justify-center group" title="Gunakan Lokasi Saat Ini">
                                    <i class="mdi mdi-crosshairs-gps text-2xl group-hover:scale-110 transition-transform"></i>
                                </button>

                                <div id="mapLoader" class="absolute inset-0 bg-white/80 backdrop-blur-sm flex items-center justify-center z-[500] hidden">
                                    <div class="flex flex-col items-center">
                                        <i class="mdi mdi-loading mdi-spin text-5xl text-emerald-500 mb-3"></i>
                                        <span class="text-sm font-bold text-slate-700 tracking-wide" id="mapLoaderText">Memproses lokasi...</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Detail Alamat Lengkap <span class="text-red-500">*</span></label>
                                <span id="autoAddressIndicator" class="text-[10px] font-bold text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full hidden"><i class="mdi mdi-autorenew"></i> Otomatis dari Pin</span>
                            </div>
                            <textarea id="alamatDetail" name="alamat_toko" class="input-premium w-full bg-slate-50/50 border border-slate-200 text-slate-900 text-sm font-medium rounded-xl px-4 py-4 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none min-h-[100px] resize-none leading-relaxed" placeholder="Contoh: Jl. Raya Pantura No. 45. Gudang atap seng biru, gerbang besi hitam. (Bisa diperbarui dengan menggeser pin peta)" required>{{ $toko->alamat_toko ?? '' }}</textarea>
                        </div>

                        {{-- HIDDEN COORDS UNTUK DATABASE --}}
                        <input type="hidden" name="latitude" id="latitude" value="{{ $toko->latitude ?? '-6.558935' }}">
                        <input type="hidden" name="longitude" id="longitude" value="{{ $toko->longitude ?? '107.763321' }}">
                    </div>
                </div>

                {{-- KEBIJAKAN B2B --}}
                <div class="bg-white rounded-[2rem] p-7 shadow-[0_2px_20px_rgba(0,0,0,0.02)] border border-slate-100">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center text-rose-600">
                            <i class="mdi mdi-shield-alert-outline text-xl"></i>
                        </div>
                        <h3 class="text-base font-bold text-slate-800">Kebijakan B2B</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Syarat Pemesanan (Opsional)</label>
                            <textarea name="catatan_toko" class="input-premium w-full bg-slate-50/50 border border-slate-200 text-slate-900 text-sm font-medium rounded-xl px-4 py-4 focus:bg-white focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 outline-none min-h-[120px] resize-none" placeholder="Cth: Minimal pemesanan truk pasir adalah 1 kubik. Jalan harus masuk mobil double...">{{ $toko->catatan_toko ?? '' }}</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kebijakan Retur Material</label>
                            <textarea name="kebijakan_retur" class="input-premium w-full bg-rose-50/30 border border-rose-100 text-slate-900 text-sm font-medium rounded-xl px-4 py-4 focus:bg-white focus:ring-2 focus:ring-rose-500/20 focus:border-rose-300 outline-none min-h-[120px] resize-none" placeholder="Cth: Semen yang sudah mengeras karena hujan di lokasi proyek tidak dapat diretur...">{{ $toko->kebijakan_retur ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- STICKY SAVE BAR (GLASSMORPHISM) --}}
        <div class="fixed bottom-0 left-0 lg:left-[260px] right-0 glass-effect border-t border-slate-200/50 px-6 py-5 flex items-center justify-between z-50 shadow-[0_-10px_40px_-10px_rgba(0,0,0,0.1)]">
            <div class="hidden sm:flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                    <i class="mdi mdi-check-all text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-800 m-0">Siap menyimpan perubahan?</p>
                    <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Periksa kembali koordinat peta Anda.</p>
                </div>
            </div>
            <button type="submit" id="btnSubmitProfile" class="w-full sm:w-auto px-10 py-4 bg-slate-900 hover:bg-black text-white font-black rounded-xl shadow-xl shadow-slate-900/20 transition-all flex items-center justify-center gap-3 transform hover:-translate-y-0.5">
                <i class="mdi mdi-content-save-check-outline text-2xl"></i> SIMPAN PROFIL TOKO
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
        const mapContainer = document.getElementById('map');
        const alamatDetail = document.getElementById('alamatDetail');
        const autoIndicator = document.getElementById('autoAddressIndicator');
        const loader = document.getElementById('mapLoader');
        const loaderText = document.getElementById('mapLoaderText');

        let currentLat = parseFloat(latInput.value) || -6.558935;
        let currentLng = parseFloat(lngInput.value) || 107.763321;

        // 1. INISIALISASI PETA
        const map = L.map(mapContainer, {
            center: [currentLat, currentLng],
            zoom: 15,
            zoomControl: false
        });

        L.control.zoom({ position: 'bottomleft' }).addTo(map);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap &copy; CARTO'
        }).addTo(map);

        // Custom Marker Premium
        const customIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-violet.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        const marker = L.marker([currentLat, currentLng], { draggable: true, icon: customIcon }).addTo(map);

        // ==========================================
        // 🛠️ ULTIMATE BUG FIX UNTUK GREY TILES MAP
        // ==========================================
        const forceMapRender = () => {
            if(map) map.invalidateSize(true);
        };
        // Tembak invalidateSize bertahap untuk mengakali delay render Tailwind CSS
        setTimeout(forceMapRender, 100);
        setTimeout(forceMapRender, 500);
        setTimeout(forceMapRender, 1000);

        // Gunakan ResizeObserver sebagai penjaga utama
        if (window.ResizeObserver) {
            const resizeObserver = new ResizeObserver(() => {
                forceMapRender();
            });
            resizeObserver.observe(mapContainer);
        }
        window.addEventListener('resize', forceMapRender);

        // 2. FUNGSI REVERSE GEOCODING (Pin -> Teks Alamat)
        async function getAddressFromCoords(lat, lng) {
            try {
                const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`);
                const data = await response.json();
                if(data && data.display_name) {
                    alamatDetail.value = data.display_name;
                    autoIndicator.classList.remove('hidden');
                    setTimeout(() => autoIndicator.classList.add('hidden'), 4000);
                }
            } catch (error) {
                console.error("Geocoding error:", error);
            }
        }

        // 3. EVENT HANDLERS MARKER
        marker.on('dragend', function (e) {
            const p = e.target.getLatLng();
            latInput.value = p.lat.toFixed(8);
            lngInput.value = p.lng.toFixed(8);
            map.panTo(p);
            getAddressFromCoords(p.lat, p.lng);
        });

        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            latInput.value = e.latlng.lat.toFixed(8);
            lngInput.value = e.latlng.lng.toFixed(8);
            map.panTo(e.latlng);
            getAddressFromCoords(e.latlng.lat, e.latlng.lng);
        });

        // 4. FUNGSI PENCARIAN PETA
        window.cariLokasiMap = async function() {
            const query = document.getElementById('searchLokasi').value;
            if(query.length < 3) {
                Toast.fire({icon: 'warning', title: 'Ketik minimal 3 karakter'});
                return;
            }

            const btn = document.getElementById('btnSearchMap');
            btn.innerHTML = '<i class="mdi mdi-loading mdi-spin"></i>';
            btn.disabled = true;
            loaderText.innerText = "Mencari lokasi...";
            loader.classList.remove('hidden');

            try {
                const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`);
                const data = await response.json();

                if(data.length > 0) {
                    const res = data[0];
                    const newLat = parseFloat(res.lat);
                    const newLng = parseFloat(res.lon);

                    map.setView([newLat, newLng], 17);
                    marker.setLatLng([newLat, newLng]);
                    latInput.value = newLat.toFixed(8);
                    lngInput.value = newLng.toFixed(8);

                    alamatDetail.value = res.display_name;
                    Toast.fire({icon: 'success', title: 'Lokasi ditemukan!'});
                } else {
                    Toast.fire({icon: 'error', title: 'Lokasi tidak ditemukan'});
                }
            } catch(e) {
                Toast.fire({icon: 'error', title: 'Terjadi kesalahan jaringan'});
            } finally {
                btn.innerHTML = 'Cari';
                btn.disabled = false;
                loader.classList.add('hidden');
            }
        }

        // 5. FITUR TRACKING GPS (LACAK LOKASI SAYA)
        window.getLocation = function() {
            const btnGps = document.getElementById('btnGps');

            if (navigator.geolocation) {
                btnGps.classList.add('gps-active');
                loaderText.innerText = "Mengambil koordinat GPS Anda...";
                loader.classList.remove('hidden');

                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;

                        // Update Peta & Marker
                        map.setView([lat, lng], 17);
                        marker.setLatLng([lat, lng]);

                        // Update Form
                        latInput.value = lat.toFixed(8);
                        lngInput.value = lng.toFixed(8);

                        // Ambil detail nama jalan
                        getAddressFromCoords(lat, lng);

                        loader.classList.add('hidden');
                        btnGps.classList.remove('gps-active');
                        Toast.fire({icon: 'success', title: 'GPS berhasil dilacak!'});
                    },
                    function(error) {
                        loader.classList.add('hidden');
                        btnGps.classList.remove('gps-active');

                        let msg = "Gagal melacak lokasi.";
                        if(error.code === 1) msg = "Izin akses GPS ditolak oleh browser.";
                        else if(error.code === 2) msg = "Sinyal GPS tidak ditemukan.";
                        else if(error.code === 3) msg = "Waktu permintaan GPS habis.";

                        Toast.fire({icon: 'error', title: msg});
                    },
                    { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                );
            } else {
                Toast.fire({icon: 'error', title: 'Browser Anda tidak mendukung fitur GPS.'});
            }
        };
    });

    // ==========================================
    // LOGIKA DRAG & DROP FILE YANG SEMPURNA
    // ==========================================
    function setupDropzone(dropzoneId, inputId, nameId) {
        const dropzone = document.getElementById(dropzoneId);
        const input = document.getElementById(inputId);
        const icon = dropzone.querySelector('.drop-icon');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, () => {
                dropzone.classList.add('dropzone-active');
                icon.classList.remove('text-slate-400');
                icon.classList.add('text-blue-500');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, () => {
                dropzone.classList.remove('dropzone-active');
                icon.classList.remove('text-blue-500');
                icon.classList.add('text-slate-400');
            }, false);
        });

        dropzone.addEventListener('drop', (e) => {
            let dt = e.dataTransfer;
            let files = dt.files;
            input.files = files; // Assign dropped files to input
            updateFileName(input, nameId, dropzoneId);
        });
    }

    // Setup drag and drop
    setupDropzone('dropzoneNIB', 'nibInput', 'nibName');
    setupDropzone('dropzoneNPWP', 'npwpInput', 'npwpName');

    // Update File Name UI
    window.updateFileName = function(input, targetId, dropzoneId) {
        if(input.files && input.files.length > 0) {
            const fileName = input.files[0].name;
            const target = document.getElementById(targetId);
            target.innerHTML = `<span class="text-blue-600 flex items-center gap-1 justify-center"><i class="mdi mdi-check-decagram text-lg"></i> ${fileName}</span>`;
            document.getElementById(dropzoneId).classList.add('border-blue-400', 'bg-blue-50');
        }
    }

    // PREVIEW IMAGE (Logo & Banner)
    window.previewImage = function(input, previewId, placeholderId = null) {
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

    // LOADING STATE SAAT SUBMIT
    document.getElementById('profileForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmitProfile');
        btn.innerHTML = '<i class="mdi mdi-loading mdi-spin text-2xl"></i> MEMPROSES...';
        btn.classList.add('opacity-80', 'cursor-not-allowed', 'scale-95');
        btn.disabled = true;
    });
</script>
@endpush
