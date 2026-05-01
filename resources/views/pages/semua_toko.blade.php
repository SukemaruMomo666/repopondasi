<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Direktori Mitra Toko - Pondasikita</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'sans-serif'] },
                    colors: {
                        brand: {
                            50: '#eff6ff', 100: '#dbeafe', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8',
                        }
                    },
                    boxShadow: {
                        'card': '0 4px 20px -2px rgba(0,0,0,0.05)',
                        'card-hover': '0 20px 40px -4px rgba(37,99,235,0.15)',
                    }
                }
            }
        }
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }

        /* Hilangkan panah default pada select option */
        select.custom-select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        /* Pagination Override Laravel */
        .pagination-wrap nav { display: flex; justify-content: center; width: 100%; margin-top: 3rem; margin-bottom: 2rem; }
        .pagination-wrap .pagination { display: flex; gap: 0.5rem; background: white; padding: 0.5rem; border-radius: 1rem; box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: 1px solid #e4e4e7; }
        .pagination-wrap .page-item .page-link { display: flex; align-items: center; justify-content: center; min-width: 2.5rem; height: 2.5rem; border-radius: 0.5rem; font-weight: 700; color: #52525b; padding: 0 0.75rem; transition: all 0.3s; }
        .pagination-wrap .page-item:not(.active) .page-link:hover { background: #f4f4f5; color: #000; }
        .pagination-wrap .page-item.active .page-link { background: #2563eb; color: white; box-shadow: 0 4px 15px rgba(37,99,235,0.4); }
    </style>
</head>
<body class="text-zinc-800 antialiased pt-[80px]">

    {{-- Include Navbar --}}
    @include('partials.navbar')

    {{-- HERO SECTION DIREKTORI TOKO (B&W Theme) --}}
    <div class="bg-[#09090b] relative overflow-hidden">
        {{-- Abstract Glow --}}
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-blue-600/20 rounded-full blur-[100px] pointer-events-none"></div>
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-[0.05] pointer-events-none"></div>

        <div class="max-w-[1250px] mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20 relative z-10 flex flex-col items-center text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 text-blue-400 text-[10px] font-black tracking-widest uppercase mb-6 shadow-lg backdrop-blur-md">
                <i class="fas fa-shield-check text-blue-500"></i> Partner Resmi
            </div>
            <h1 class="text-4xl lg:text-6xl font-black text-white tracking-tight mb-6">
                Jaringan Mitra <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-white">Terpercaya</span>
            </h1>
            <p class="text-zinc-400 max-w-2xl text-base lg:text-lg font-medium leading-relaxed">
                Eksplorasi ribuan distributor dan toko material bangunan tersertifikasi dari seluruh Indonesia untuk menyuplai proyek skala kecil hingga mega-konstruksi Anda.
            </p>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="max-w-[1250px] mx-auto px-4 sm:px-6 lg:px-8 py-8 relative -mt-10 z-20">

        {{-- FILTER BAR (Floating style) --}}
        <div class="bg-white/90 backdrop-blur-xl p-3 sm:p-4 rounded-2xl border border-white shadow-[0_8px_30px_rgba(0,0,0,0.06)] flex flex-col sm:flex-row items-center justify-between gap-4 mb-10">

            <div class="flex items-center gap-3 text-zinc-800 font-bold px-2">
                <div class="w-10 h-10 rounded-xl bg-zinc-100 flex items-center justify-center text-blue-600">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <span>Filter Wilayah</span>
            </div>

            <form action="{{ route('toko.index') }}" method="GET" class="w-full sm:w-auto flex items-center gap-2">
                <div class="relative w-full sm:w-[300px]">
                    <select name="lokasi" class="custom-select w-full bg-zinc-50 border border-zinc-200 text-zinc-700 text-sm font-semibold rounded-xl focus:bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 block pl-4 pr-10 py-3 transition-all outline-none cursor-pointer">
                        <option value="semua">Nasional (Seluruh Kota)</option>
                        @foreach($locations as $lokasi)
                            <option value="{{ $lokasi->city_id }}" {{ ($filter_lokasi ?? '') == $lokasi->city_id ? 'selected' : '' }}>
                                {{ $lokasi->city_name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <i class="fas fa-chevron-down text-zinc-400 text-xs"></i>
                    </div>
                </div>
                <button type="submit" class="bg-black hover:bg-blue-600 text-white px-6 py-3 rounded-xl font-bold transition-colors shadow-md shrink-0">
                    Cari
                </button>
            </form>

        </div>

        {{-- INFO COUNT --}}
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-xl font-black text-zinc-900 tracking-tight">Direktori Toko</h2>
            <span class="text-sm font-semibold text-zinc-500 bg-white border border-zinc-200 px-3 py-1 rounded-full shadow-sm">{{ $stores->total() }} Toko Aktif</span>
        </div>

        {{-- DAFTAR TOKO GRID (NEW DESIGN) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-8">

            @forelse($stores as $toko)
                @php
                    // Logika Inisial Avatar
                    $words = explode(" ", $toko->nama_toko);
                    $acronym = "";
                    foreach ($words as $w) { $acronym .= mb_substr($w, 0, 1); }
                    $storeInitials = strtoupper(substr($acronym, 0, 2)) ?: "TK";

                    // Logika Banner & Logo
                    $bannerPath = 'assets/uploads/banners/' . ($toko->banner_toko ?? '');
                    $hasBanner = !empty($toko->banner_toko) && file_exists(public_path($bannerPath));

                    $logoPath = 'assets/uploads/logos/' . ($toko->logo_toko ?? '');
                    $hasLogo = !empty($toko->logo_toko) && file_exists(public_path($logoPath));

                    // TEMA WARNA BERDASARKAN TIER TOKO
                    $tier = $toko->tier_toko ?? 'regular';

                    if ($tier == 'official_store') {
                        // Tema Ungu (Official)
                        $badgeClass  = 'bg-[#6366f1] text-white shadow-md shadow-indigo-500/30';
                        $badgeText   = 'OFFICIAL';
                        $pinColor    = 'text-[#c084fc]'; // Pin ungu muda
                        $bagBgColor  = 'bg-[#6366f1]';
                        $bannerStyle = $hasBanner ? "background-image: url('".asset($bannerPath)."');" : "background: linear-gradient(135deg, #4f46e5, #7c3aed);";
                    } elseif ($tier == 'pro_merchant') {
                        // Tema Hijau (Power)
                        $badgeClass  = 'bg-[#10b981] text-white shadow-md shadow-emerald-500/30';
                        $badgeText   = '<i class="fas fa-bolt text-[8px] mr-1"></i> POWER';
                        $pinColor    = 'text-[#34d399]'; // Pin hijau muda
                        $bagBgColor  = 'bg-[#10b981]';
                        $bannerStyle = $hasBanner ? "background-image: url('".asset($bannerPath)."');" : "background: linear-gradient(135deg, #059669, #10b981);";
                    } else {
                        // Tema Hitam/Abu (Verified / Regular)
                        $badgeClass  = 'bg-zinc-800/80 backdrop-blur-md text-white border border-white/10 shadow-sm';
                        $badgeText   = '<span class="w-1 h-1 rounded-full bg-zinc-400 mr-1.5 inline-block"></span> VERIFIED';
                        $pinColor    = 'text-blue-400'; // Pin biru
                        $bagBgColor  = 'bg-blue-500';
                        $bannerStyle = $hasBanner ? "background-image: url('".asset($bannerPath)."');" : "background-color: #18181b;";
                    }
                @endphp

                <a href="{{ route('toko.detail', ['slug' => $toko->slug]) }}" class="group bg-white rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 border border-zinc-100 overflow-hidden flex flex-col relative">

                    {{-- Banner Card --}}
                    <div class="h-28 bg-cover bg-center relative" style="{{ $bannerStyle }}">
                        {{-- Top Right Badge (Dinamis) --}}
                        <div class="absolute top-3 right-3 px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest flex items-center justify-center {{ $badgeClass }}">
                            {!! $badgeText !!}
                        </div>
                    </div>

                    {{-- Body Content --}}
                    <div class="px-5 pb-5 relative flex-1 flex flex-col bg-white rounded-t-[1.5rem] -mt-4">

                        {{-- Avatar Wrapper --}}
                        <div class="-mt-8 mb-3 relative inline-block w-max">

                            {{-- Foto / Inisial --}}
                            @if($hasLogo)
                                <img src="{{ asset($logoPath) }}" alt="{{ $toko->nama_toko }}" class="w-[68px] h-[68px] rounded-[1.1rem] object-cover border-[3px] border-white shadow-sm bg-white">
                            @else
                                <div class="w-[68px] h-[68px] rounded-[1.1rem] border-[3px] border-white shadow-sm flex items-center justify-center font-black text-xl text-white bg-zinc-800">
                                    {{ $storeInitials }}
                                </div>
                            @endif

                            {{-- Floating Icon Kecil Kanan Bawah --}}
                            <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-white rounded-lg flex items-center justify-center">
                                <div class="w-[18px] h-[18px] rounded-[5px] flex items-center justify-center text-[8px] text-white {{ $bagBgColor }}">
                                    <i class="fas fa-store"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Nama & Lokasi Toko --}}
                        <h4 class="font-black text-lg text-zinc-900 group-hover:text-blue-600 transition-colors line-clamp-1 leading-tight">
                            {{ $toko->nama_toko }}
                        </h4>
                        <p class="text-[9px] font-black text-zinc-400 uppercase tracking-widest mt-1.5 flex items-center gap-1.5 line-clamp-1">
                            <i class="fas fa-map-marker-alt {{ $pinColor }}"></i> {{ $toko->city_name }}
                        </p>

                        {{-- Bagian Bawah (Koleksi Produk & Tombol Panah) --}}
                        <div class="mt-8 flex items-end justify-between">
                            <div>
                                <span class="text-[9px] font-black text-zinc-300 uppercase tracking-widest block mb-0.5">Koleksi</span>
                                <span class="text-sm font-black text-zinc-800 block">{{ number_format($toko->jumlah_produk) }} Produk</span>
                            </div>

                            {{-- Soft Grey Button --}}
                            <div class="w-9 h-9 rounded-xl bg-zinc-50 flex items-center justify-center text-zinc-400 group-hover:bg-zinc-900 group-hover:text-white transition-all duration-300">
                                <i class="fas fa-arrow-right -rotate-45 text-xs"></i>
                            </div>
                        </div>

                    </div>
                </a>

            @empty
                {{-- EMPTY STATE --}}
                <div class="col-span-full flex flex-col items-center justify-center py-24 bg-white rounded-3xl border border-dashed border-zinc-300 shadow-sm">
                    <div class="w-24 h-24 bg-zinc-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-store-slash text-4xl text-zinc-400"></i>
                    </div>
                    <h3 class="text-2xl font-black text-zinc-900 mb-2">Toko Tidak Ditemukan</h3>
                    <p class="text-zinc-500 font-medium text-center max-w-md mb-8">Belum ada mitra toko yang terdaftar di lokasi pencarian ini. Silakan perluas area pencarian Anda.</p>

                    @if(($filter_lokasi ?? 'semua') !== 'semua')
                        <a href="{{ route('toko.index') }}" class="bg-black hover:bg-blue-600 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-lg flex items-center gap-2">
                            <i class="fas fa-globe-asia"></i> Tampilkan Semua Kota
                        </a>
                    @endif
                </div>
            @endforelse

        </div>

        {{-- PAGINASI --}}
        <div class="pagination-wrap">
            {{ $stores->links() }}
        </div>

    </div>

    {{-- Include Footer --}}
    @include('partials.footer')
    <script src="{{ asset('assets/js/navbar.js') }}"></script>
</body>
</html>
