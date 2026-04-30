@extends('layouts.seller')

@section('title', 'Profil & Legalitas Toko')

@push('styles')
{{-- LEAFLET CSS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
{{-- FONT AWESOME UNTUK MATCH DENGAN REFERENSI --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    /* HIDE SCROLLBAR BUT KEEP FUNCTIONALITY */
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    /* LEAFLET Z-INDEX FIX */
    .leaflet-container {
        z-index: 10 !important;
        font-family: 'Inter', sans-serif;
    }

    /* CUSTOM TAILWIND UTILITIES */
    .shadow-soft { box-shadow: 0 4px 40px -4px rgba(0,0,0,0.03); }
    .shadow-float { box-shadow: 0 10px 30px -5px rgba(0,0,0,0.08); }
    .shadow-glow { box-shadow: 0 0 20px rgba(37,99,235,0.3); }

    .upload-overlay { transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
    .group:hover .upload-overlay { opacity: 1; }

    .dropzone-active {
        border-color: #3b82f6 !important;
        background-color: #eff6ff !important;
        transform: scale(1.02);
    }

    .input-premium {
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* ANIMASI GPS BUTTON */
    @keyframes pulse-ring {
        0% { transform: scale(0.8); box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.5); }
        70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(37, 99, 235, 0); }
        100% { transform: scale(0.8); box-shadow: 0 0 0 0 rgba(37, 99, 235, 0); }
    }
    .gps-active {
        animation: pulse-ring 2s infinite;
        background-color: #1d4ed8 !important;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-[#f4f4f5] p-4 md:p-6 lg:p-8 font-sans text-zinc-800 pb-36">

    {{-- SWEETALERT SETUP DEWA --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true, position: 'top-end', showConfirmButton: false, timer: 4000,
            timerProgressBar: true, customClass: { popup: 'rounded-2xl shadow-float border border-zinc-100 font-sans' }
        });

        document.addEventListener('DOMContentLoaded', () => {
            @if(session('success'))
                Toast.fire({icon: 'success', title: '{{ session("success") }}'});
            @endif

            @if($errors->any())
                let errorList = "<ul class='text-left text-xs mt-2 space-y-1 list-disc pl-4 text-red-600 font-medium'>";
                @foreach($errors->all() as $error)
                    errorList += "<li>{{ $error }}</li>";
                @endforeach
                errorList += "</ul>";

                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal!',
                    html: '<p class="text-sm text-zinc-600">Mohon lengkapi data berikut:</p>' + errorList,
                    customClass: { popup: 'rounded-3xl shadow-float border border-zinc-100 font-sans' },
                    confirmButtonColor: '#3b82f6',
                    confirmButtonText: 'Baik, Saya Perbaiki'
                });
            @endif
        });
    </script>

    {{-- HEADER --}}
    <div class="mb-8">
        <h1 class="text-3xl font-black text-black tracking-tight">Profil & Legalitas Toko</h1>
        <p class="text-sm font-medium text-zinc-500 mt-1">Kelola informasi bisnis, dokumen legal, dan titik koordinat logistik armada Anda.</p>
    </div>

    <form action="{{ route('seller.shop.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            {{-- KOLOM KIRI: VISUAL & DATA LEGAL --}}
            <div class="lg:col-span-4 space-y-8 relative z-20">

                {{-- VISUAL BRANDING --}}
                <div class="bg-white rounded-[2rem] p-7 shadow-soft border border-zinc-200">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                            <i class="fas fa-palette text-lg"></i>
                        </div>
                        <h3 class="text-base font-bold text-zinc-900">Visual Branding</h3>
                    </div>

                    {{-- Logo --}}
                    <div class="relative w-32 h-32 mx-auto rounded-full shadow-float p-1.5 bg-white mb-8 group cursor-pointer" onclick="document.getElementById('logoInput').click()">
                        @php $logoUrl = !empty($toko->logo_toko) ? asset('assets/uploads/logos/'.$toko->logo_toko) : 'https://ui-avatars.com/api/?name='.urlencode($toko->nama_toko ?? 'Toko').'&background=f4f4f5&color=52525b&size=300'; @endphp
                        <img id="logoPreview" src="{{ $logoUrl }}" class="w-full h-full rounded-full object-cover border border-zinc-100">
                        <div class="absolute inset-1.5 bg-black/50 rounded-full flex flex-col items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity backdrop-blur-sm">
                            <i class="fas fa-camera text-xl mb-1"></i>
                            <span class="text-[9px] font-bold tracking-widest uppercase">Ubah Logo</span>
                        </div>
                    </div>
                    <input type="file" id="logoInput" name="logo_toko" class="hidden" accept="image/jpeg,image/png,image/jpg" onchange="previewImage(this, 'logoPreview')">

                    {{-- Banner --}}
                    <div>
                        <div class="relative w-full h-32 rounded-2xl border-2 border-dashed border-zinc-200 overflow-hidden group cursor-pointer flex items-center justify-center bg-zinc-50 hover:bg-blue-50 hover:border-blue-300 transition-colors" onclick="document.getElementById('bannerInput').click()">
                            @if(!empty($toko->banner_toko))
                                <img id="bannerPreview" src="{{ asset('assets/uploads/banners/'.$toko->banner_toko) }}" class="absolute inset-0 w-full h-full object-cover">
                            @else
                                <img id="bannerPreview" src="" class="absolute inset-0 w-full h-full object-cover hidden">
                                <div id="bannerPlaceholder" class="text-center text-zinc-400 group-hover:text-blue-500 transition-colors">
                                    <i class="fas fa-image text-3xl mb-2"></i>
                                    <div class="text-xs font-bold">Upload Banner</div>
                                    <div class="text-[10px] font-medium mt-1 opacity-70">1200x300px (Max 2MB)</div>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-pen text-xl"></i>
                            </div>
                        </div>
                        <input type="file" id="bannerInput" name="banner_toko" class="hidden" accept="image/jpeg,image/png,image/jpg" onchange="previewImage(this, 'bannerPreview', 'bannerPlaceholder')">
                    </div>
                </div>

                {{-- DOKUMEN LEGALITAS (DRAG & DROP) --}}
                <div class="bg-white rounded-[2rem] p-7 shadow-soft border border-zinc-200">
                    <div class="mb-6">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                                <i class="fas fa-file-contract text-lg"></i>
                            </div>
                            <h3 class="text-base font-bold text-zinc-900">Dokumen Bisnis</h3>
                        </div>
                        <p class="text-xs font-medium text-zinc-500 leading-relaxed">Syarat wajib untuk tender & verifikasi lencana <span class="font-bold text-blue-600">Official Store</span>.</p>
                    </div>

                    <div class="space-y-5">
                        {{-- NIB --}}
                        <div>
                            <label class="block text-[11px] font-black text-zinc-400 uppercase tracking-widest mb-2">Dokumen NIB *</label>
                            <div id="dropzoneNIB" class="border-2 border-dashed border-zinc-200 rounded-2xl p-5 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-all duration-300 relative overflow-hidden" onclick="document.getElementById('nibInput').click()">
                                <input type="file" id="nibInput" name="dokumen_nib" class="hidden absolute inset-0" accept=".pdf,.jpg,.jpeg,.png" onchange="updateFileName(this, 'nibName', 'dropzoneNIB')">
                                <div class="relative z-10 flex flex-col items-center justify-center pointer-events-none">
                                    <i class="fas fa-cloud-upload-alt text-2xl text-zinc-300 mb-2 drop-icon"></i>
                                    <div id="nibName" class="text-xs font-bold text-zinc-600">
                                        @if(!empty($toko->dokumen_nib))
                                            <span class="text-emerald-600"><i class="fas fa-check-circle"></i> {{ $toko->dokumen_nib }}</span>
                                        @else
                                            Drag & drop atau klik disini
                                        @endif
                                    </div>
                                    <div class="text-[9px] text-zinc-400 mt-1 uppercase tracking-wider">PDF / JPG Max 5MB</div>
                                </div>
                            </div>
                        </div>

                        {{-- NPWP --}}
                        <div>
                            <label class="block text-[11px] font-black text-zinc-400 uppercase tracking-widest mb-2">Dokumen NPWP *</label>
                            <div id="dropzoneNPWP" class="border-2 border-dashed border-zinc-200 rounded-2xl p-5 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-all duration-300 relative overflow-hidden" onclick="document.getElementById('npwpInput').click()">
                                <input type="file" id="npwpInput" name="dokumen_npwp" class="hidden absolute inset-0" accept=".pdf,.jpg,.jpeg,.png" onchange="updateFileName(this, 'npwpName', 'dropzoneNPWP')">
                                <div class="relative z-10 flex flex-col items-center justify-center pointer-events-none">
                                    <i class="fas fa-cloud-upload-alt text-2xl text-zinc-300 mb-2 drop-icon"></i>
                                    <div id="npwpName" class="text-xs font-bold text-zinc-600">
                                        @if(!empty($toko->dokumen_npwp))
                                            <span class="text-emerald-600"><i class="fas fa-check-circle"></i> {{ $toko->dokumen_npwp }}</span>
                                        @else
                                            Drag & drop atau klik disini
                                        @endif
                                    </div>
                                    <div class="text-[9px] text-zinc-400 mt-1 uppercase tracking-wider">PDF / JPG Max 5MB</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: IDENTITAS & MAPS --}}
            <div class="lg:col-span-8 space-y-8 relative z-10">

                {{-- INFORMASI DASAR --}}
                <div class="bg-white rounded-[2rem] shadow-soft border border-zinc-200 p-6 sm:p-8">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-zinc-100">
                        <i class="fas fa-store text-blue-600 text-lg"></i>
                        <h3 class="text-lg font-black text-black">Informasi Identitas</h3>
                    </div>

                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[11px] font-black text-zinc-400 uppercase tracking-widest mb-2">Nama Toko Resmi <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_toko" class="input-premium w-full bg-zinc-50 border border-zinc-200 text-zinc-900 text-sm font-bold rounded-xl px-4 py-3.5 focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none" value="{{ old('nama_toko', $toko->nama_toko ?? '') }}" required>
                            </div>
                            <div>
                                <label class="block text-[11px] font-black text-zinc-400 uppercase tracking-widest mb-2">WhatsApp Admin <span class="text-red-500">*</span></label>
                                <div class="flex border border-zinc-200 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-blue-500/20 focus-within:border-blue-500 focus-within:bg-white bg-zinc-50 transition-all">
                                    <span class="bg-zinc-100 px-4 py-3.5 text-zinc-500 font-bold border-r border-zinc-200 flex items-center">+62</span>
                                    <input type="number" name="no_telepon" class="input-premium w-full px-4 py-3.5 text-sm font-bold outline-none bg-transparent" value="{{ old('no_telepon', ltrim($toko->telepon_toko ?? '', '0')) }}" placeholder="8123456xxxx" required>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-zinc-400 uppercase tracking-widest mb-2">Slogan / Tagline Bisnis</label>
                            <input type="text" name="slogan" class="input-premium w-full bg-zinc-50 border border-zinc-200 text-zinc-900 text-sm font-bold rounded-xl px-4 py-3.5 focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none" value="{{ old('slogan', $toko->slogan ?? '') }}" placeholder="Cth: Solusi Material Konstruksi Terbaik & Terpercaya">
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-zinc-400 uppercase tracking-widest mb-2">Deskripsi Lengkap Toko</label>
                            <textarea name="deskripsi_toko" class="input-premium w-full bg-zinc-50 border border-zinc-200 text-zinc-900 text-sm leading-relaxed font-medium rounded-xl px-4 py-4 focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none min-h-[120px] resize-none" placeholder="Ceritakan sejarah, keunggulan, dan detail layanan armada pengiriman Anda...">{{ old('deskripsi_toko', $toko->deskripsi_toko ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- LOKASI & PETA --}}
                <div class="bg-white rounded-[2rem] shadow-soft border border-zinc-200 p-6 sm:p-8">

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                                <i class="fas fa-map-marker-alt text-lg"></i>
                            </div>
                            <h3 class="text-lg font-black text-black">Titik Koordinat Lokasi</h3>
                        </div>
                        <button type="button" onclick="getLocation()" id="btnGps" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-xs font-bold transition-all shadow-glow flex items-center justify-center gap-2">
                            <i class="fas fa-crosshairs"></i> Gunakan GPS Saya
                        </button>
                    </div>

                    <p class="text-sm font-medium text-zinc-500 mb-6">Geser pin merah di bawah ini ke lokasi gudang/proyek Anda untuk akurasi pengiriman material (Armada Truk).</p>

                    <div class="space-y-6">
                        {{-- DROPDOWN WILAYAH --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-[11px] font-black text-zinc-400 uppercase tracking-widest mb-2">Provinsi <span class="text-red-500">*</span></label>
                                <select name="province_id" class="input-premium w-full bg-white border border-zinc-200 text-sm font-bold rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none" required>
                                    <option value="">Pilih Provinsi</option>
                                    <option value="2" {{ old('province_id', $toko->province_id ?? '') == '2' ? 'selected' : '' }}>JAWA BARAT</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[11px] font-black text-zinc-400 uppercase tracking-widest mb-2">Kota/Kab. <span class="text-red-500">*</span></label>
                                <select name="city_id" class="input-premium w-full bg-white border border-zinc-200 text-sm font-bold rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none" required>
                                    <option value="">Pilih Kota</option>
                                    <option value="21" {{ old('city_id', $toko->city_id ?? '') == '21' ? 'selected' : '' }}>KABUPATEN SUBANG</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[11px] font-black text-zinc-400 uppercase tracking-widest mb-2">Kecamatan <span class="text-red-500">*</span></label>
                                <select name="district_id" class="input-premium w-full bg-white border border-zinc-200 text-sm font-bold rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none" required>
                                    <option value="">Pilih Kecamatan</option>
                                    <option value="215" {{ old('district_id', $toko->district_id ?? '') == '215' ? 'selected' : '' }}>Pagaden</option>
                                </select>
                            </div>
                        </div>

                        {{-- SEARCH PETA --}}
                        <div class="flex gap-2">
                            <div class="relative flex-1">
                                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-zinc-400"></i>
                                <input type="text" id="searchLokasi" class="input-premium w-full bg-zinc-50 border border-zinc-200 text-zinc-900 text-sm font-bold rounded-xl pl-11 pr-4 py-3 focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none" placeholder="Cari nama jalan atau patokan..." onkeydown="if(event.key === 'Enter'){ event.preventDefault(); cariLokasiMap(); }">
                            </div>
                            <button type="button" onclick="cariLokasiMap()" id="btnSearchMap" class="bg-zinc-900 hover:bg-black text-white px-6 py-3 rounded-xl text-sm font-bold transition-all shadow-md">
                                Cari
                            </button>
                        </div>

                        {{-- MAP CONTAINER --}}
                        <div class="relative w-full h-[400px] rounded-2xl overflow-hidden border border-zinc-200 z-10 bg-zinc-100">
                            <div id="map" class="absolute inset-0 w-full h-full"></div>

                            {{-- OVERLAY PIN TERKUNCI --}}
                            <div class="absolute bottom-4 left-4 z-[400] bg-white/95 backdrop-blur-sm p-3.5 rounded-2xl shadow-float border border-zinc-100 min-w-[200px]">
                                <div class="flex items-center gap-2 mb-2.5">
                                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_8px_rgba(16,185,129,0.6)]"></div>
                                    <span class="text-[10px] font-black text-zinc-900 tracking-widest uppercase">PIN TERKUNCI</span>
                                </div>
                                <div class="flex justify-between items-center text-xs mb-1">
                                    <span class="text-zinc-500 font-bold">Lat:</span>
                                    <span class="text-blue-600 font-black" id="displayLat">-6.200000</span>
                                </div>
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-zinc-500 font-bold">Lng:</span>
                                    <span class="text-blue-600 font-black" id="displayLng">106.816666</span>
                                </div>
                            </div>

                            {{-- OVERLAY LOADING --}}
                            <div id="mapLoader" class="absolute inset-0 bg-white/80 backdrop-blur-sm flex items-center justify-center z-[500] hidden">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-circle-notch fa-spin text-4xl text-blue-600 mb-3"></i>
                                    <span class="text-xs font-bold text-zinc-700 tracking-wide uppercase" id="mapLoaderText">Memproses lokasi...</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-[11px] font-black text-zinc-400 uppercase tracking-widest">Detail Alamat Lengkap <span class="text-red-500">*</span></label>
                                <span id="autoAddressIndicator" class="text-[10px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded-md hidden"><i class="fas fa-magic"></i> Auto-fill dari Pin</span>
                            </div>

                            {{-- HIDDEN FIELDS UNTUK MENYESUAIKAN VALIDASI CONTROLLER LAMA --}}
                            <input type="hidden" name="kota" id="inputKota" value="{{ old('kota', $toko->kota ?? '') }}">
                            <input type="hidden" name="kode_pos" id="inputKodePos" value="{{ old('kode_pos', $toko->kode_pos ?? '') }}">

                            {{-- NAME KEMBALI KE alamat_lengkap AGAR CONTROLLER TIDAK MARAH --}}
                            <textarea id="alamatDetail" name="alamat_lengkap" class="input-premium w-full bg-zinc-50 border border-zinc-200 text-zinc-900 text-sm font-medium rounded-xl px-4 py-4 focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none min-h-[90px] resize-none leading-relaxed" placeholder="Contoh: Jl. Raya Pantura No. 45. Gudang atap seng biru, gerbang besi hitam." required>{{ old('alamat_lengkap', $toko->alamat_toko ?? '') }}</textarea>
                        </div>

                        {{-- HIDDEN COORDS UNTUK DATABASE --}}
                        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $toko->latitude ?? '-6.558935') }}">
                        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $toko->longitude ?? '107.763321') }}">
                    </div>
                </div>

                {{-- KEBIJAKAN B2B --}}
                <div class="bg-white rounded-[2rem] shadow-soft border border-zinc-200 p-6 sm:p-8">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-zinc-100">
                        <i class="fas fa-shield-alt text-blue-600 text-lg"></i>
                        <h3 class="text-lg font-black text-black">Kebijakan B2B</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[11px] font-black text-zinc-400 uppercase tracking-widest mb-2">Syarat Pemesanan</label>
                            <textarea name="catatan_toko" class="input-premium w-full bg-zinc-50 border border-zinc-200 text-zinc-900 text-sm font-medium rounded-xl px-4 py-4 focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none min-h-[120px] resize-none" placeholder="Cth: Minimal pemesanan armada truk adalah...">{{ old('catatan_toko', $toko->catatan_toko ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-zinc-400 uppercase tracking-widest mb-2">Kebijakan Retur</label>
                            <textarea name="kebijakan_retur" class="input-premium w-full bg-red-50/30 border border-red-100 text-zinc-900 text-sm font-medium rounded-xl px-4 py-4 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-red-300 outline-none min-h-[120px] resize-none" placeholder="Cth: Material yang rusak karena pembeli tidak dapat diretur...">{{ old('kebijakan_retur', $toko->kebijakan_retur ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- STICKY SAVE BAR --}}
        <div class="fixed bottom-0 left-0 lg:left-[260px] right-0 bg-white/95 backdrop-blur-md border-t border-zinc-200 px-6 py-5 flex items-center justify-between z-50 shadow-[0_-10px_40px_-10px_rgba(0,0,0,0.05)]">
            <div class="hidden sm:flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                    <i class="fas fa-check"></i>
                </div>
                <div>
                    <p class="text-sm font-bold text-zinc-900 m-0">Siap menyimpan perubahan?</p>
                    <p class="text-[11px] font-semibold text-zinc-500 uppercase tracking-wider">Periksa kembali koordinat peta Anda.</p>
                </div>
            </div>
            <button type="submit" id="btnSubmitProfile" class="w-full sm:w-auto px-8 py-3.5 bg-zinc-900 hover:bg-black text-white font-bold rounded-xl shadow-float transition-all flex items-center justify-center gap-2 transform hover:-translate-y-0.5 text-sm">
                <i class="fas fa-save"></i> SIMPAN PROFIL TOKO
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
        const displayLat = document.getElementById('displayLat');
        const displayLng = document.getElementById('displayLng');
        const mapContainer = document.getElementById('map');
        const alamatDetail = document.getElementById('alamatDetail');
        const autoIndicator = document.getElementById('autoAddressIndicator');
        const loader = document.getElementById('mapLoader');
        const loaderText = document.getElementById('mapLoaderText');

        let currentLat = parseFloat(latInput.value) || -6.558935;
        let currentLng = parseFloat(lngInput.value) || 107.763321;

        function updateDisplayCoords(lat, lng) {
            displayLat.innerText = parseFloat(lat).toFixed(6);
            displayLng.innerText = parseFloat(lng).toFixed(6);
            latInput.value = parseFloat(lat).toFixed(8);
            lngInput.value = parseFloat(lng).toFixed(8);
        }

        // 1. INISIALISASI PETA
        const map = L.map(mapContainer, {
            center: [currentLat, currentLng],
            zoom: 15,
            zoomControl: false
        });

        L.control.zoom({ position: 'topright' }).addTo(map);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap &copy; CARTO'
        }).addTo(map);

        // Custom Marker
        const customIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        const marker = L.marker([currentLat, currentLng], { draggable: true, icon: customIcon }).addTo(map);
        updateDisplayCoords(currentLat, currentLng);

        // BUG FIX GREY TILES (ResizeObserver)
        const forceMapRender = () => { if(map) map.invalidateSize(); };
        setTimeout(forceMapRender, 200);
        setTimeout(forceMapRender, 600);

        if (window.ResizeObserver) {
            const resizeObserver = new ResizeObserver(() => { forceMapRender(); });
            resizeObserver.observe(mapContainer);
        }

        // 2. FUNGSI REVERSE GEOCODING DENGAN KOTA & KODE POS UNTUK CONTROLLER
        async function getAddressFromCoords(lat, lng) {
            try {
                const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`);
                const data = await response.json();
                if(data && data.address) {
                    // Extract kota dan kode pos dari hasil reverse geocoding
                    const addr = data.address;
                    const city = addr.city || addr.town || addr.municipality || addr.county || addr.state_district || "";
                    document.getElementById('inputKota').value = city;
                    document.getElementById('inputKodePos').value = addr.postcode || "";

                    if(data.display_name) {
                        alamatDetail.value = data.display_name;
                        autoIndicator.classList.remove('hidden');
                        setTimeout(() => autoIndicator.classList.add('hidden'), 4000);
                    }
                }
            } catch (error) {
                console.error("Geocoding error:", error);
            }
        }

        // Jika form kosong saat pertama diload, panggil geocoder
        if(!document.getElementById('inputKota').value || !alamatDetail.value) {
            getAddressFromCoords(currentLat, currentLng);
        }

        // 3. EVENT HANDLERS MARKER
        marker.on('dragend', function (e) {
            const p = e.target.getLatLng();
            updateDisplayCoords(p.lat, p.lng);
            map.panTo(p);
            getAddressFromCoords(p.lat, p.lng);
        });

        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            updateDisplayCoords(e.latlng.lat, e.latlng.lng);
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
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            btn.disabled = true;
            loaderText.innerText = "MENCARI LOKASI...";
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
                    updateDisplayCoords(newLat, newLng);

                    // Panggil geocoding agar kota dan kodepos ikut terupdate
                    getAddressFromCoords(newLat, newLng);

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

        // 5. FITUR TRACKING GPS
        window.getLocation = function() {
            const btnGps = document.getElementById('btnGps');

            if (navigator.geolocation) {
                btnGps.classList.add('gps-active');
                btnGps.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Melacak...';
                loaderText.innerText = "MENGAMBIL KOORDINAT GPS ANDA...";
                loader.classList.remove('hidden');

                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;

                        map.setView([lat, lng], 17);
                        marker.setLatLng([lat, lng]);
                        updateDisplayCoords(lat, lng);
                        getAddressFromCoords(lat, lng);

                        loader.classList.add('hidden');
                        btnGps.classList.remove('gps-active');
                        btnGps.innerHTML = '<i class="fas fa-crosshairs"></i> Gunakan GPS Saya';
                        Toast.fire({icon: 'success', title: 'GPS berhasil dilacak!'});
                    },
                    function(error) {
                        loader.classList.add('hidden');
                        btnGps.classList.remove('gps-active');
                        btnGps.innerHTML = '<i class="fas fa-crosshairs"></i> Gunakan GPS Saya';

                        let msg = "Gagal melacak lokasi.";
                        if(error.code === 1) msg = "Izin akses GPS ditolak.";
                        else if(error.code === 2) msg = "Sinyal GPS tidak ditemukan.";
                        else if(error.code === 3) msg = "Waktu permintaan GPS habis.";

                        Toast.fire({icon: 'error', title: msg});
                    },
                    { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                );
            } else {
                Toast.fire({icon: 'error', title: 'Browser tidak mendukung GPS.'});
            }
        };
    });

    // DRAG AND DROP SETUP
    function setupDropzone(dropzoneId, inputId, nameId) {
        const dropzone = document.getElementById(dropzoneId);
        const input = document.getElementById(inputId);
        const icon = dropzone.querySelector('.drop-icon');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, e => { e.preventDefault(); e.stopPropagation(); }, false);
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, () => {
                dropzone.classList.add('dropzone-active');
                icon.classList.remove('text-zinc-300');
                icon.classList.add('text-blue-500');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, () => {
                dropzone.classList.remove('dropzone-active');
                icon.classList.remove('text-blue-500');
                icon.classList.add('text-zinc-300');
            }, false);
        });

        dropzone.addEventListener('drop', (e) => {
            input.files = e.dataTransfer.files;
            updateFileName(input, nameId, dropzoneId);
        });
    }

    setupDropzone('dropzoneNIB', 'nibInput', 'nibName');
    setupDropzone('dropzoneNPWP', 'npwpInput', 'npwpName');

    window.updateFileName = function(input, targetId, dropzoneId) {
        if(input.files && input.files.length > 0) {
            document.getElementById(targetId).innerHTML = `<span class="text-blue-600 flex items-center gap-1 justify-center"><i class="fas fa-check-circle"></i> ${input.files[0].name}</span>`;
            document.getElementById(dropzoneId).classList.add('border-blue-400', 'bg-blue-50');
        }
    }

    window.previewImage = function(input, previewId, placeholderId = null) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById(previewId).src = e.target.result;
                document.getElementById(previewId).classList.remove('hidden');
                if(placeholderId) document.getElementById(placeholderId).classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // FORM SUBMIT HANDLING
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        const btn = document.getElementById('btnSubmitProfile');
        setTimeout(() => {
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> MEMPROSES...';
            btn.classList.add('opacity-80', 'cursor-not-allowed', 'scale-95');
            btn.disabled = true;
        }, 10);
    });
</script>
@endpush
