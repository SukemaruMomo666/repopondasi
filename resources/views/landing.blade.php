<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $settings['app_name'] ?? 'Pondasikita' }} - Premium B2B Material</title>
    <meta name="description" content="{{ $settings['seo_description'] ?? 'Platform Jual Beli Bahan Bangunan Terlengkap se-Indonesia' }}">

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        primary: '#2563eb', // Electric Blue 600
                        primaryGlow: '#3b82f6', // Blue 500
                        secondary: '#000000', // Pure Black
                        surface: '#09090b', // Zinc 950
                        accent: '#ffffff', // Pure White
                    },
                    animation: {
                        'blink': 'blink 0.7s infinite',
                        'blob': 'blob 10s infinite alternate',
                        'pulse-glow': 'pulse-glow 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'flash-pulse': 'flash-pulse 1.5s ease-in-out infinite'
                    },
                    keyframes: {
                        blink: { '0%, 100%': { opacity: 1 }, '50%': { opacity: 0 } },
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '100%': { transform: 'translate(20px, -30px) scale(1.1)' }
                        },
                        'pulse-glow': {
                            '0%, 100%': { opacity: 1, boxShadow: '0 0 0 0 rgba(37, 99, 235, 0.7)' },
                            '50%': { opacity: .8, boxShadow: '0 0 0 15px rgba(37, 99, 235, 0)' }
                        },
                        'flash-pulse': {
                            '0%, 100%': { opacity: 1 },
                            '50%': { opacity: 0.5 }
                        }
                    }
                }
            }
        }
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Tambahkan AlpineJS untuk Fitur View More, Popup, & Countdown --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #fafafa; }
        .glass-panel { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.6); }
        .glass-dark { background: rgba(9, 9, 11, 0.6); backdrop-filter: blur(24px); border: 1px solid rgba(255, 255, 255, 0.08); }
        .text-gradient { background: linear-gradient(135deg, #ffffff 0%, #a1a1aa 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .typing-cursor { display: inline-block; width: 4px; background: #3b82f6; margin-left: 6px; border-radius: 2px; }

        /* Hide scrollbar for slider */
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

        /* Smooth Scrollbar General */
        ::-webkit-scrollbar { width: 4px; }
        @media (min-width: 768px) { ::-webkit-scrollbar { width: 6px; } }
        ::-webkit-scrollbar-track { background: #f4f4f5; }
        ::-webkit-scrollbar-thumb { background: #3b82f6; border-radius: 10px; }

        /* Utility untuk Animasi AlpineJS */
        [x-cloak] { display: none !important; }

        /* Flash Sale Progress Bar */
        .progress-bar-striped { background-image: linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent); background-size: 1rem 1rem; }
    </style>
</head>
<body class="text-zinc-900 antialiased selection:bg-primary selection:text-white overflow-x-hidden"
      x-data="landingPageData()"
      x-init="initPage()">

    {{-- ========================================================
         1. POPUP PROMO (ALA SHOPEE/TOKOPEDIA)
         ======================================================== --}}
    @if(($settings['enable_welcome_popup'] ?? '0') == '1' && !empty($settings['popup_image']))
    <div x-show="showPopup" x-cloak
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">

        <div class="relative w-full max-w-xs sm:max-w-sm mx-auto" @click.outside="closePopup()">
            {{-- Tombol Close X --}}
            <button @click="closePopup()" class="absolute -top-12 right-0 w-10 h-10 bg-white/20 hover:bg-white/40 text-white rounded-full flex items-center justify-center text-xl backdrop-blur transition-all outline-none">
                <i class="fas fa-times"></i>
            </button>

            {{-- Poster Promo --}}
            <a href="{{ $settings['popup_link'] ?? '#' }}" class="block w-full rounded-2xl overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.5)] transform transition-transform hover:scale-[1.02]">
                <img src="{{ asset('storage/' . $settings['popup_image']) }}" class="w-full h-auto object-cover" alt="Promo Spesial">
            </a>
        </div>
    </div>
    @endif

    {{-- Navbar --}}
    @include('partials.navbar')

    {{-- ========================================================
         2. HERO SECTION : B&W + BLUE PREMIUM EDITION
         ======================================================== --}}
    <section class="relative bg-zinc-950 pt-20 pb-16 sm:pt-24 sm:pb-20 lg:pt-36 lg:pb-32 overflow-hidden border-b border-zinc-800 w-full">
        {{-- Ambient Glow --}}
        <div class="absolute top-0 left-1/4 w-[300px] md:w-[600px] h-[300px] md:h-[500px] bg-blue-600/10 rounded-full mix-blend-screen filter blur-[80px] md:blur-[120px] animate-blob"></div>
        <div class="absolute bottom-0 right-1/4 w-[250px] md:w-[500px] h-[250px] md:h-[500px] bg-blue-800/10 rounded-full mix-blend-screen filter blur-[80px] md:blur-[120px] animate-blob" style="animation-delay: 2s;"></div>

        <div class="container mx-auto px-4 relative z-10 grid lg:grid-cols-12 gap-10 lg:gap-16 items-start">

            {{-- TEXT AREA --}}
            <div class="lg:col-span-5 space-y-6 md:space-y-8 text-center lg:text-left pt-4 lg:pt-0">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/5 border border-white/10 text-blue-400 text-[9px] md:text-[10px] font-black tracking-widest uppercase">
                    <span class="w-1.5 h-1.5 md:w-2 md:h-2 rounded-full bg-blue-500 animate-pulse"></span> Sistem V2.0 Aktif
                </div>

                <div class="space-y-1 md:space-y-2">
                    <h1 class="text-3xl sm:text-4xl lg:text-6xl font-black text-white leading-tight tracking-tight">
                        {{ $settings['hero_title'] ?? 'Ekosistem Material,' }}
                    </h1>
                    {{-- AREA TEKS MENGETIK --}}
                    <div class="h-[60px] sm:h-[80px] md:h-[100px] lg:h-[120px] flex items-start justify-center lg:justify-start">
                        <span class="text-2xl sm:text-3xl lg:text-5xl font-black">
                            <span class="typing-text text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-blue-600"></span><span class="typing-cursor animate-blink text-blue-500">&nbsp;</span>
                        </span>
                    </div>
                </div>

                <p class="text-sm md:text-base text-zinc-400 max-w-lg mx-auto lg:mx-0 font-medium leading-relaxed px-4 lg:px-0">
                    {{ $settings['hero_subtitle'] ?? 'Arsitektur pengadaan B2B masa depan. Temukan ribuan supplier dengan transparansi harga dan manajemen RAB.' }}
                </p>

                <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center lg:justify-start w-full px-4 lg:px-0">
                    <a href="{{ url('pages/produk') }}" class="w-full sm:w-auto group bg-white text-zinc-900 font-black py-3.5 px-6 md:py-4 md:px-8 rounded-xl transition-all hover:shadow-[0_0_30px_rgba(37,99,235,0.3)] flex items-center justify-center gap-3 text-sm md:text-base">
                        <i class="fas fa-layer-group text-blue-600"></i> Eksplorasi Katalog
                    </a>
                    <a href="#toko" class="w-full sm:w-auto bg-transparent hover:bg-white/5 text-white font-semibold py-3.5 px-6 md:py-4 md:px-8 rounded-xl transition-all flex items-center justify-center gap-3 border border-zinc-700 hover:border-blue-500 text-sm md:text-base">
                        <i class="fas fa-store text-blue-400"></i> Direktori Mitra
                    </a>
                </div>
            </div>

            {{-- DYNAMIC BANNER --}}
            <div class="lg:col-span-7 relative w-full px-2 sm:px-0">
                <div class="absolute top-4 left-6 md:top-8 md:left-12 flex gap-2 z-40" id="slider-dots"></div>
                <div class="relative w-full aspect-[4/3] sm:aspect-video lg:aspect-[16/10] rounded-3xl md:rounded-[2.5rem] overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.5)] md:shadow-[0_30px_70px_rgba(0,0,0,0.7)] border border-white/10 group bg-zinc-900 cursor-pointer">

                    {{-- Invisibile Click Zones --}}
                    <div class="absolute inset-y-0 left-0 w-1/2 z-30" onclick="moveSlider(-1)"></div>
                    <div class="absolute inset-y-0 right-0 w-1/2 z-30" onclick="moveSlider(1)"></div>

                    {{-- Slider Track --}}
                    <div id="hero-slider" class="flex w-full h-full transition-transform duration-700 ease-in-out">
                        @php
                            $validBanners = [];

                            // 1. Cek Hero Image (DB + File Fisik)
                            if(!empty($settings['hero_image']) && file_exists(public_path('storage/' . $settings['hero_image']))) {
                                $validBanners[] = [
                                    'img' => asset('storage/' . $settings['hero_image']),
                                    'title' => $settings['hero_title'] ?? '',
                                    'desc' => $settings['hero_subtitle'] ?? ''
                                ];
                            }

                            // 2. Cek Banner Tambahan 1-4
                            for($i = 1; $i <= 4; $i++) {
                                $imgK = 'hero_image_' . $i;
                                if(!empty($settings[$imgK]) && file_exists(public_path('storage/' . $settings[$imgK]))) {
                                    if(count($validBanners) < 4) {
                                        $validBanners[] = [
                                            'img' => asset('storage/' . $settings[$imgK]),
                                            'title' => $settings['hero_title_'.$i] ?? '',
                                            'desc' => $settings['hero_subtitle_'.$i] ?? ''
                                        ];
                                    }
                                }
                            }
                        @endphp

                        @forelse($validBanners as $banner)
                            <div class="min-w-full h-full relative flex-shrink-0 bg-zinc-950">
                                <img src="{{ $banner['img'] }}" class="w-full h-full object-cover" alt="Banner Utama" onerror="this.style.display='none'">
                                <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/20 to-transparent"></div>

                                @if(!empty($banner['title']) && $banner['title'] != ($settings['hero_title'] ?? ''))
                                <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8 lg:p-12 transform translate-y-2 md:translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-blue-600 text-white text-[9px] md:text-[10px] font-black rounded-lg uppercase tracking-widest mb-2 md:mb-4">
                                        <i class="fas fa-bolt"></i> Info Platform
                                    </div>
                                    <h3 class="text-xl sm:text-3xl lg:text-4xl font-black text-white mb-2 md:mb-3 drop-shadow-xl">{{ $banner['title'] }}</h3>
                                    <p class="text-zinc-300 text-xs sm:text-sm lg:text-base font-medium line-clamp-2 max-w-xl">{{ $banner['desc'] }}</p>
                                </div>
                                @endif
                            </div>
                        @empty
                            {{-- FALLBACK ELEGAN JIKA BELUM ADA BANNER --}}
                            <div class="min-w-full h-full relative flex-shrink-0 bg-gradient-to-br from-blue-900 via-zinc-900 to-black flex flex-col items-center justify-center p-6 text-center">
                                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 20px 20px;"></div>
                                <div class="w-16 h-16 md:w-20 md:h-20 bg-white/10 backdrop-blur-md rounded-2xl md:rounded-3xl flex items-center justify-center text-blue-400 text-3xl md:text-4xl mb-4 md:mb-6 shadow-2xl border border-white/10">
                                    <i class="fas fa-layer-group"></i>
                                </div>
                                <h3 class="text-xl sm:text-2xl lg:text-3xl font-black text-white mb-2 relative z-10 tracking-tight">Katalog Material B2B</h3>
                                <p class="text-zinc-400 font-medium text-xs sm:text-sm relative z-10">Ruang iklan promosi akan tampil di sini.</p>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </section>

    <main class="container mx-auto px-4 py-8 lg:py-10 space-y-12 lg:space-y-16 relative z-20 overflow-hidden w-full">

        {{-- ========================================================
             3. FLASH SALE SECTION
             ======================================================== --}}
        @if(isset($flashSaleProducts) && count($flashSaleProducts) > 0)
        <section class="relative bg-gradient-to-r from-red-600 to-orange-500 rounded-3xl md:rounded-[2.5rem] p-5 sm:p-6 lg:p-10 shadow-xl overflow-hidden w-full">
            <div class="absolute top-0 right-0 w-32 h-32 md:w-64 md:h-64 bg-white/20 rounded-full blur-2xl md:blur-3xl"></div>

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 md:mb-8 gap-4 relative z-10">
                <div class="flex items-center gap-3 md:gap-4">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-white text-red-600 rounded-xl md:rounded-2xl flex items-center justify-center text-xl md:text-2xl shadow-lg shrink-0">
                        <i class="fas fa-bolt animate-flash-pulse"></i>
                    </div>
                    <div>
                        <h2 class="text-xl sm:text-2xl lg:text-3xl font-black text-white tracking-tight leading-none">FLASH SALE</h2>
                        <p class="text-red-100 text-xs sm:text-sm font-medium mt-1">Material murah berakhir dalam:</p>
                    </div>
                </div>
                {{-- Countdown Timer --}}
                <div class="flex gap-1.5 md:gap-2 text-white font-black font-mono text-sm sm:text-lg md:text-xl" x-data="countdown('{{ $flashSaleEndTime ?? '' }}')">
                    <div class="bg-black/30 backdrop-blur-md px-2 py-1.5 md:px-3 md:py-2 rounded-lg md:rounded-xl" x-text="hours">00</div><span class="py-1.5 md:py-2">:</span>
                    <div class="bg-black/30 backdrop-blur-md px-2 py-1.5 md:px-3 md:py-2 rounded-lg md:rounded-xl" x-text="minutes">00</div><span class="py-1.5 md:py-2">:</span>
                    <div class="bg-black/30 backdrop-blur-md px-2 py-1.5 md:px-3 md:py-2 rounded-lg md:rounded-xl" x-text="seconds">00</div>
                </div>
            </div>

            {{-- Flash Sale Products Scroll --}}
            <div class="flex gap-3 md:gap-4 overflow-x-auto pb-4 scrollbar-hide snap-x -mx-5 px-5 sm:mx-0 sm:px-0">
                @foreach($flashSaleProducts as $fs)
                    @php
                        $harga_coret = $fs->harga;
                        $harga_diskon = $fs->harga_flash_sale ?? ($fs->harga * 0.8);
                        $persen = round((($harga_coret - $harga_diskon) / $harga_coret) * 100);
                        $terjual = $fs->stok_terjual ?? rand(10, 50);
                        $total_stok = $fs->stok_flash_sale ?? 100;
                        $persen_terjual = min(100, round(($terjual / $total_stok) * 100));
                    @endphp
                    <a href="{{ route('produk.detail', $fs->id) }}" class="snap-start shrink-0 w-[140px] sm:w-44 md:w-56 bg-white rounded-2xl p-2.5 md:p-3 shadow-lg hover:-translate-y-1 md:hover:-translate-y-2 transition-transform duration-300 group">
                        <div class="relative w-full aspect-square rounded-xl overflow-hidden bg-zinc-100 mb-2 md:mb-3">
                            <img src="{{ asset('assets/uploads/products/'.($fs->gambar_utama ?? 'default.jpg')) }}" onerror="this.src='https://images.unsplash.com/photo-1589939705384-5185137a7f0f?q=80&w=600'" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $fs->nama_barang }}">
                            <div class="absolute top-1.5 right-1.5 md:top-2 md:right-2 bg-red-500 text-white text-[9px] md:text-[10px] font-black px-1.5 md:px-2 py-0.5 md:py-1 rounded-md">-{{ $persen }}%</div>
                        </div>
                        <h3 class="text-[11px] md:text-xs font-bold text-zinc-800 line-clamp-2 min-h-[1.75rem] md:min-h-[2rem] leading-snug mb-1">{{ $fs->nama_barang }}</h3>
                        <div class="font-black text-red-600 text-sm md:text-lg mb-0.5 md:mb-1 truncate">Rp {{ number_format($harga_diskon, 0, ',', '.') }}</div>
                        <div class="text-[9px] md:text-[10px] text-zinc-400 line-through mb-1.5 md:mb-2 truncate">Rp {{ number_format($harga_coret, 0, ',', '.') }}</div>

                        <div class="w-full bg-red-100 rounded-full h-2.5 md:h-3.5 relative overflow-hidden">
                            <div class="bg-red-500 h-full progress-bar-striped transition-all duration-1000" style="width: {{ $persen_terjual }}%"></div>
                            <span class="absolute inset-0 flex items-center justify-center text-[7px] md:text-[8px] font-black text-white drop-shadow-md">TERJUAL {{ $terjual }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
        @endif

        {{-- ========================================================
             4. KATEGORI UTAMA (ALPINEJS VIEW MORE)
             ======================================================== --}}
        <section x-data="{ showAll: false }" class="w-full">
            <div class="text-center max-w-2xl mx-auto mb-8 md:mb-10">
                <h2 class="text-[9px] md:text-[10px] font-black tracking-[0.2em] md:tracking-[0.3em] text-blue-600 uppercase mb-2 md:mb-3 relative inline-block">
                    <span class="hidden sm:block absolute top-1/2 -left-12 w-8 h-px bg-blue-600/30"></span>
                    Direktori Material
                    <span class="hidden sm:block absolute top-1/2 -right-12 w-8 h-px bg-blue-600/30"></span>
                </h2>
                <h3 class="text-2xl md:text-3xl lg:text-4xl font-black text-black tracking-tight mt-1">Kategori Utama</h3>
            </div>

            {{-- Grid Kategori --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 sm:gap-4 md:gap-6 lg:gap-8 relative pb-6">

                @forelse($categories ?? [] as $index => $cat)
                    <div class="relative group/card h-full hover:z-50"
                         @if($index >= 6)
                             x-show="showAll"
                             x-transition:enter="transition ease-out duration-500"
                             x-transition:enter-start="opacity-0 translate-y-4"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-cloak
                         @endif>

                        @if(isset($cat->subkategori) && count($cat->subkategori) > 0)
                            <div class="hidden lg:flex absolute inset-0 bg-white border border-blue-200 shadow-xl rounded-[1.5rem] z-20 transition-all duration-300 ease-[cubic-bezier(0.34,1.56,0.64,1)] origin-center opacity-0 pointer-events-none group-hover/card:opacity-100 group-hover/card:translate-x-8 group-hover/card:translate-y-3 group-hover/card:rotate-[10deg] group-hover/card:pointer-events-auto hover:!translate-x-2 hover:!translate-y-2 hover:!rotate-0 hover:!scale-105 hover:!z-[60] hover:!shadow-[0_30px_60px_rgba(37,99,235,0.25)] hover:!border-blue-500 flex-col p-4">
                                <span class="text-[9px] font-black text-blue-600 uppercase tracking-widest mb-2 border-b border-blue-100 pb-1.5 shrink-0 flex items-center">
                                    <i class="fas fa-list-ul mr-1.5"></i> Sub Kategori
                                </span>
                                <div class="flex-1 overflow-y-auto scrollbar-hide flex flex-col gap-1">
                                    @foreach($cat->subkategori as $sub)
                                        <a href="{{ url('pages/produk?kategori=' . $sub->id) }}" class="block px-2 py-2 text-[11px] font-bold text-zinc-500 hover:text-white hover:bg-blue-600 rounded-lg transition-colors truncate">
                                            {{ $sub->nama_kategori }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <a href="{{ url('pages/produk?kategori=' . $cat->id) }}"
                           class="block relative w-full h-full bg-white p-4 md:p-5 lg:p-6 rounded-2xl md:rounded-[1.5rem] shadow-[0_2px_10px_rgb(0,0,0,0.02)] transition-all duration-300 ease-out z-30 lg:group-hover/card:shadow-2xl lg:group-hover/card:-translate-y-3 lg:group-hover/card:-translate-x-3 lg:group-hover/card:-rotate-[5deg] border border-zinc-100/80 lg:group-hover/card:border-blue-300 flex flex-col items-center justify-center gap-3 md:gap-4 bg-clip-padding">

                            <div class="relative w-12 h-12 md:w-16 md:h-16 rounded-xl md:rounded-2xl bg-zinc-50 text-zinc-600 flex items-center justify-center text-lg md:text-2xl lg:group-hover/card:bg-blue-600 lg:group-hover/card:text-white transition-colors duration-300 shadow-inner">
                                <i class="{{ $cat->icon_class ?? 'fas fa-tools' }}"></i>
                            </div>

                            <p class="font-bold text-zinc-700 text-center text-[11px] md:text-sm lg:group-hover/card:text-blue-600 transition-colors leading-tight line-clamp-2 px-1">
                                {{ $cat->nama_kategori }}
                            </p>
                        </a>
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center text-zinc-400 py-12 md:py-16 border border-dashed border-zinc-200 rounded-2xl md:rounded-3xl bg-white/50">
                        <i class="fas fa-folder-open text-3xl md:text-4xl mb-3 md:mb-4 text-zinc-300"></i>
                        <span class="font-medium text-xs md:text-sm">Kategori belum tersedia.</span>
                    </div>
                @endforelse

                @if(isset($categories) && count($categories) > 6)
                    <div x-show="!showAll" class="absolute bottom-0 left-0 right-0 h-24 md:h-32 bg-gradient-to-t from-[#fafafa] to-transparent pointer-events-none z-10 translate-y-2"></div>
                @endif
            </div>

            @if(isset($categories) && count($categories) > 6)
            <div class="mt-4 md:mt-8 flex justify-center relative z-20">
                <button @click="showAll = !showAll"
                        class="group relative inline-flex items-center justify-center px-6 py-3 md:px-10 md:py-4 font-black tracking-tighter text-zinc-700 bg-white rounded-xl md:rounded-2xl border border-zinc-200 overflow-hidden transition-all duration-500 hover:border-blue-500 hover:text-blue-600 hover:shadow-[0_20px_40px_rgba(37,99,235,0.2)] hover:-translate-y-1 active:scale-95">

                    <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-blue-500/10 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] pointer-events-none"></div>
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500 bg-[radial-gradient(circle_at_center,_rgba(37,99,235,0.05)_0%,_transparent_70%)]"></div>

                    <div class="relative flex items-center gap-2 md:gap-3">
                        <span class="text-[10px] md:text-xs uppercase tracking-[0.1em] md:tracking-[0.2em]" x-text="showAll ? 'Ringkas Kategori' : 'Lihat Semua'"></span>
                        <div class="relative flex items-center justify-center w-5 h-5 md:w-6 md:h-6 rounded-lg bg-zinc-50 group-hover:bg-blue-50 transition-colors duration-500">
                            <i class="fas text-[9px] md:text-[10px] transition-transform duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)]"
                               :class="showAll ? 'fa-minus rotate-180' : 'fa-plus group-hover:rotate-90'"></i>
                        </div>
                    </div>
                </button>
            </div>
            @endif

            <style>
                @keyframes shimmer { 100% { transform: translateX(100%); } }
            </style>
        </section>

        {{-- ========================================================
             5. FLOATING TECH VALUES (PENGISI GAP)
             ======================================================== --}}
        <section class="relative py-0 overflow-hidden rounded-3xl md:rounded-[3rem] bg-zinc-50/50 border border-zinc-100">
            <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: radial-gradient(#2563eb 0.5px, transparent 0.5px); background-size: 24px 24px;"></div>
            <div class="container mx-auto p-4 md:p-8 relative z-10 w-full">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 md:gap-8">
                    {{-- Card 1 --}}
                    <div class="group relative p-6 md:p-8 rounded-2xl md:rounded-[2rem] bg-white/50 backdrop-blur-sm border border-white hover:border-blue-200 transition-all duration-500 hover:shadow-[0_20px_50px_rgba(37,99,235,0.05)] hover:-translate-y-1 md:hover:-translate-y-2 lg:animate-float">
                        <div class="w-12 h-12 md:w-14 md:h-14 rounded-xl md:rounded-2xl bg-gradient-to-br from-blue-500 to-blue-700 text-white flex items-center justify-center text-xl md:text-2xl mb-4 md:mb-6 shadow-lg shadow-blue-500/20 group-hover:scale-110 transition-transform duration-500">
                            <i class="fas fa-microchip"></i>
                        </div>
                        <h4 class="text-lg md:text-xl font-black text-zinc-800 mb-2 md:mb-3 tracking-tight">Smart Inventory</h4>
                        <p class="text-xs md:text-sm text-zinc-500 font-medium leading-relaxed">Pantau ketersediaan stok material di gudang supplier secara <span class="text-blue-600">real-time</span>.</p>
                        <div class="absolute bottom-0 left-6 right-6 md:left-8 md:right-8 h-1 bg-gradient-to-r from-transparent via-blue-500/20 to-transparent scale-x-0 group-hover:scale-x-100 transition-transform duration-700"></div>
                    </div>
                    {{-- Card 2 --}}
                    <div class="group relative p-6 md:p-8 rounded-2xl md:rounded-[2rem] bg-white/50 backdrop-blur-sm border border-white hover:border-blue-200 transition-all duration-500 hover:shadow-[0_20px_50px_rgba(37,99,235,0.05)] hover:-translate-y-1 md:hover:-translate-y-2 lg:animate-float" style="animation-delay: 1.5s;">
                        <div class="w-12 h-12 md:w-14 md:h-14 rounded-xl md:rounded-2xl bg-zinc-900 text-white flex items-center justify-center text-xl md:text-2xl mb-4 md:mb-6 shadow-lg shadow-zinc-900/20 group-hover:bg-blue-600 transition-colors duration-500">
                            <i class="fas fa-handshake-angle"></i>
                        </div>
                        <h4 class="text-lg md:text-xl font-black text-zinc-800 mb-2 md:mb-3 tracking-tight">Transparansi B2B</h4>
                        <p class="text-xs md:text-sm text-zinc-500 font-medium leading-relaxed">Dapatkan kontrak digital yang mengikat antara pembeli dan supplier. <span class="text-blue-600">No Hidden Cost</span>.</p>
                        <div class="absolute bottom-0 left-6 right-6 md:left-8 md:right-8 h-1 bg-gradient-to-r from-transparent via-blue-500/20 to-transparent scale-x-0 group-hover:scale-x-100 transition-transform duration-700"></div>
                    </div>
                    {{-- Card 3 --}}
                    <div class="group relative p-6 md:p-8 rounded-2xl md:rounded-[2rem] bg-white/50 backdrop-blur-sm border border-white hover:border-blue-200 transition-all duration-500 hover:shadow-[0_20px_50px_rgba(37,99,235,0.05)] hover:-translate-y-1 md:hover:-translate-y-2 lg:animate-float" style="animation-delay: 3s;">
                        <div class="w-12 h-12 md:w-14 md:h-14 rounded-xl md:rounded-2xl bg-zinc-100 text-zinc-400 flex items-center justify-center text-xl md:text-2xl mb-4 md:mb-6 group-hover:bg-blue-600 group-hover:text-white transition-all duration-500">
                            <i class="fas fa-route"></i>
                        </div>
                        <h4 class="text-lg md:text-xl font-black text-zinc-800 mb-2 md:mb-3 tracking-tight">Optimal Logistics</h4>
                        <p class="text-xs md:text-sm text-zinc-500 font-medium leading-relaxed">Algoritma memilihkan armada terdekat untuk menghemat <span class="text-blue-600">ongkos kirim</span> hingga 30%.</p>
                        <div class="absolute bottom-0 left-6 right-6 md:left-8 md:right-8 h-1 bg-gradient-to-r from-transparent via-blue-500/20 to-transparent scale-x-0 group-hover:scale-x-100 transition-transform duration-700"></div>
                    </div>
                </div>
            </div>
        </section>

        <style>
            @media (min-width: 1024px) {
                @keyframes float {
                    0% { transform: translateY(0px); }
                    50% { transform: translateY(-15px); }
                    100% { transform: translateY(0px); }
                }
                .animate-float { animation: float 6s ease-in-out infinite; }
            }
        </style>

        {{-- ========================================================
             6. BENTO GRID FEATURE HIGHLIGHT (POTA AI)
             ======================================================== --}}
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6 relative z-20 mt-6 md:mt-10">
            <div class="lg:col-span-2 relative overflow-hidden bg-zinc-950 rounded-3xl md:rounded-[2.5rem] p-6 sm:p-8 md:p-12 flex flex-col justify-center group border border-zinc-800 shadow-2xl">
                <div class="absolute top-0 right-0 w-[250px] md:w-[400px] h-[250px] md:h-[400px] bg-blue-600/20 rounded-full mix-blend-screen filter blur-[60px] md:blur-[80px] group-hover:bg-blue-500/30 transition-colors duration-700 pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 w-[200px] md:w-[300px] h-[200px] md:h-[300px] bg-indigo-600/10 rounded-full mix-blend-screen filter blur-[60px] md:blur-[80px] pointer-events-none"></div>
                <div class="absolute -right-4 -bottom-4 md:-right-10 md:-bottom-10 opacity-[0.05] md:opacity-10 pointer-events-none"><i class="fas fa-robot text-[180px] md:text-[250px] text-white"></i></div>

                <div class="relative z-10">
                    <div class="inline-flex items-center gap-2 px-3 md:px-4 py-1 md:py-1.5 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[10px] md:text-xs font-black tracking-widest uppercase mb-4 md:mb-6 shadow-[0_0_15px_rgba(37,99,235,0.1)]">
                        <span class="relative flex h-1.5 w-1.5 md:h-2 md:w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-1.5 w-1.5 md:h-2 md:w-2 bg-blue-500"></span>
                        </span>
                        Mandor POTA AI
                    </div>
                    <h3 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black text-white mb-3 md:mb-5 leading-[1.15] md:leading-[1.1] tracking-tight">
                        Asisten Proyek Cerdas,<br class="hidden sm:block">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400">Siap 24 Jam.</span>
                    </h3>
                    <p class="text-zinc-400 max-w-md text-xs sm:text-sm md:text-base font-medium leading-relaxed pr-4 md:pr-0">
                        Tinggalkan cara lama. Biarkan AI kami menghitung kebutuhan RAB Anda, mencari supplier termurah, dan merekomendasikan material secara real-time.
                    </p>
                </div>

                <div class="relative z-10 mt-6 md:mt-10">
                    <button onclick="toggleChatWindow()" class="w-full sm:w-auto group/btn inline-flex items-center justify-center gap-3 bg-white text-zinc-900 font-black px-6 py-3.5 rounded-xl transition-all hover:bg-blue-50 hover:text-blue-600 shadow-[0_0_20px_rgba(255,255,255,0.1)] hover:-translate-y-1 text-sm md:text-base">
                        Ngobrol Sekarang
                        <i class="fas fa-arrow-right text-xs transition-transform group-hover/btn:translate-x-1"></i>
                    </button>
                </div>
            </div>

            <div class="flex flex-col gap-4 md:gap-6">
                <div class="flex-1 bg-gradient-to-br from-blue-50 to-white rounded-3xl md:rounded-[2.5rem] p-6 md:p-8 border border-blue-100 flex flex-col justify-center relative overflow-hidden group shadow-sm hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-1">
                    <div class="w-12 h-12 md:w-14 md:h-14 bg-white rounded-xl md:rounded-2xl shadow-[0_4px_15px_rgba(37,99,235,0.1)] flex items-center justify-center text-blue-600 text-xl md:text-2xl mb-4 md:mb-5 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                        <i class="fas fa-hand-holding-dollar"></i>
                    </div>
                    <h4 class="font-black text-lg md:text-xl text-zinc-800 mb-1.5 md:mb-2 tracking-tight">Harga Transparan</h4>
                    <p class="text-xs md:text-sm text-zinc-500 font-medium leading-relaxed">Bandingkan harga langsung dari tangan pertama tanpa perantara rumit.</p>
                </div>

                <div class="flex-1 bg-gradient-to-br from-zinc-50 to-white rounded-3xl md:rounded-[2.5rem] p-6 md:p-8 border border-zinc-200 flex flex-col justify-center relative overflow-hidden group shadow-sm hover:shadow-xl hover:shadow-zinc-500/10 transition-all duration-300 hover:-translate-y-1">
                    <div class="w-12 h-12 md:w-14 md:h-14 bg-white rounded-xl md:rounded-2xl shadow-[0_4px_15px_rgba(0,0,0,0.05)] flex items-center justify-center text-zinc-800 text-xl md:text-2xl mb-4 md:mb-5 group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-300">
                        <i class="fas fa-truck-fast"></i>
                    </div>
                    <h4 class="font-black text-lg md:text-xl text-zinc-800 mb-1.5 md:mb-2 tracking-tight">Logistik B2B</h4>
                    <p class="text-xs md:text-sm text-zinc-500 font-medium leading-relaxed">Sistem terintegrasi pengiriman material skala besar (truk/tronton).</p>
                </div>
            </div>
        </section>

        {{-- ========================================================
             7. MITRA TOKO TERVERIFIKASI (KOSONG DARI REQUEST)
             ======================================================== --}}
        {{-- ... Existing Card code ... --}}

        {{-- ========================================================
             8. PRODUK GRID
             ======================================================== --}}
        {{-- ... Existing Product code ... --}}

    </main>

    @include('partials.footer')
    <script src="{{ asset('assets/js/navbar.js') }}"></script>

    {{-- ===================== CHAT HUB (POTA AI & SELLER) ===================== --}}
    <button id="live-chat-toggle" class="fixed bottom-4 right-4 md:bottom-6 md:right-6 bg-black text-white p-1 pr-4 md:pr-5 rounded-full shadow-[0_10px_30px_rgba(0,0,0,0.4)] hover:shadow-[0_15px_40px_rgba(37,99,235,0.4)] transition-all duration-300 z-50 flex items-center gap-2 md:gap-3 group border border-zinc-800 hover:border-blue-500 overflow-hidden outline-none" onclick="toggleChatWindow()">
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
    <div id="live-chat-window" class="fixed bottom-20 md:bottom-24 right-4 md:right-6 w-[calc(100vw-2rem)] sm:w-[360px] md:w-[380px] h-[75vh] md:h-[580px] bg-white rounded-3xl shadow-[0_30px_60px_rgba(0,0,0,0.15)] border border-zinc-200 flex flex-col overflow-hidden z-50 transition-all duration-500 opacity-0 translate-y-10 scale-95 pointer-events-none hidden origin-bottom-right">

        {{-- Header (Black) --}}
        <div class="bg-black text-white p-4 md:p-5 flex justify-between items-center shrink-0 border-b border-zinc-800 z-10 relative">
            <div class="flex items-center gap-2.5 md:gap-3">
                <button id="chat-back-btn" onclick="showChatMenu()" class="hidden w-8 h-8 rounded-lg hover:bg-zinc-800 text-zinc-400 hover:text-white flex items-center justify-center transition-all outline-none mr-1"><i class="fas fa-chevron-left text-sm"></i></button>

                <div class="relative" id="chat-header-icon-wrap">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-zinc-900 rounded-xl flex items-center justify-center border border-zinc-800" id="chat-header-icon">
                        <i class="fas fa-comments text-blue-500 text-sm md:text-base"></i>
                    </div>
                    <div id="chat-header-ping" class="hidden absolute -bottom-1 -right-1 w-2.5 h-2.5 md:w-3 md:h-3 bg-blue-500 border-2 border-black rounded-full animate-pulse"></div>
                </div>
                <div>
                    <h4 class="font-black tracking-wide text-xs md:text-sm" id="chat-header-title">Pusat Obrolan</h4>
                    <p class="text-[9px] md:text-[10px] text-zinc-400 font-bold tracking-wider uppercase" id="chat-header-subtitle">Pilih Layanan</p>
                </div>
            </div>
            <div class="flex items-center gap-0.5 md:gap-1">
                <button id="chat-call-btn" onclick="startVoiceCallMode()" class="hidden w-7 h-7 md:w-8 md:h-8 rounded-lg hover:bg-zinc-800 text-zinc-400 hover:text-blue-400 flex items-center justify-center transition-all outline-none"><i class="fas fa-phone text-xs md:text-sm"></i></button>
                <button onclick="toggleFullScreen()" class="w-7 h-7 md:w-8 md:h-8 rounded-lg hover:bg-zinc-800 text-zinc-400 hover:text-white items-center justify-center transition-all outline-none hidden sm:flex"><i id="icon-resize" class="fas fa-expand text-xs md:text-sm"></i></button>
                <button onclick="toggleChatWindow()" class="w-7 h-7 md:w-8 md:h-8 rounded-lg hover:bg-red-500/20 text-zinc-400 hover:text-red-500 flex items-center justify-center transition-all outline-none"><i class="fas fa-xmark text-sm md:text-base"></i></button>
            </div>
        </div>

        {{-- 1. MENU VIEW --}}
        <div id="chat-menu-view" class="flex-1 p-5 md:p-6 bg-zinc-50 flex flex-col gap-4 overflow-y-auto">
            <h3 class="text-[10px] font-black text-zinc-400 uppercase tracking-widest text-center mb-2 mt-4">Pilih Metode Bantuan</h3>

            <button onclick="openChatAI()" class="w-full bg-white border border-zinc-200 hover:border-blue-500 hover:shadow-[0_10px_20px_rgba(37,99,235,0.1)] p-4 md:p-5 rounded-2xl flex items-center gap-4 transition-all text-left group outline-none">
                <div class="w-12 h-12 md:w-14 md:h-14 shrink-0 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl md:text-2xl group-hover:bg-blue-600 group-hover:text-white transition-all">
                    <i class="fas fa-robot"></i>
                </div>
                <div>
                    <h4 class="font-black text-zinc-900 text-sm md:text-base group-hover:text-blue-600 transition-colors">Tanya POTA AI</h4>
                    <p class="text-[10px] md:text-xs text-zinc-500 font-medium leading-snug mt-0.5">Asisten cerdas untuk hitung RAB, cari material, dan rekomendasi.</p>
                </div>
            </button>

            <button onclick="openChatSeller()" class="w-full bg-white border border-zinc-200 hover:border-emerald-500 hover:shadow-[0_10px_20px_rgba(16,185,129,0.1)] p-4 md:p-5 rounded-2xl flex items-center gap-4 transition-all text-left group outline-none">
                <div class="w-12 h-12 md:w-14 md:h-14 shrink-0 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-xl md:text-2xl group-hover:bg-emerald-500 group-hover:text-white transition-all">
                    <i class="fas fa-store"></i>
                </div>
                <div>
                    <h4 class="font-black text-zinc-900 text-sm md:text-base group-hover:text-emerald-600 transition-colors">Chat Penjual</h4>
                    <p class="text-[10px] md:text-xs text-zinc-500 font-medium leading-snug mt-0.5">Negosiasi harga, tanya ketersediaan stok, dan info pengiriman.</p>
                </div>
            </button>
        </div>

        {{-- 2. AI VIEW --}}
        <div id="chat-ai-view" class="hidden flex-1 flex-col h-full overflow-hidden bg-white">
            <div class="flex-1 p-4 md:p-5 overflow-y-auto bg-zinc-50 flex flex-col gap-3 md:gap-4 chat-messages relative" id="chat-messages">
                <div class="text-[9px] md:text-[10px] text-center text-zinc-400 font-bold uppercase tracking-widest mb-1 md:mb-2">Hari ini</div>
                <div class="flex gap-2 max-w-[90%] sm:max-w-[85%]">
                    <div class="w-6 h-6 md:w-8 md:h-8 rounded-lg md:rounded-xl bg-black flex-shrink-0 flex items-center justify-center text-white text-[10px] md:text-xs mt-auto"><i class="fas fa-robot text-blue-500"></i></div>
                    <div class="bg-white border border-zinc-200 text-zinc-800 p-3 md:p-3.5 rounded-2xl rounded-bl-sm text-xs md:text-sm shadow-sm relative group font-medium leading-relaxed">
                        Sistem siap, {{ auth()->user()?->nama ?? 'Juragan' }}! Cari material baja, hitung semen, atau lacak pesanan B2B?
                    </div>
                </div>
            </div>

            <div class="p-2.5 md:p-3 bg-white border-t border-zinc-200 flex items-center gap-2 shrink-0">
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
        </div>

        {{-- 3. SELLER VIEW (Placeholder) --}}
        <div id="chat-seller-view" class="hidden flex-1 flex-col p-6 bg-zinc-50 items-center justify-center text-center">
            <div class="w-20 h-20 bg-white border border-zinc-200 shadow-sm rounded-full flex items-center justify-center mb-5">
                <i class="fas fa-comments-dollar text-3xl text-emerald-500"></i>
            </div>
            <h4 class="font-black text-zinc-900 text-lg md:text-xl tracking-tight">Fitur Segera Hadir</h4>
            <p class="text-xs md:text-sm text-zinc-500 mt-2 max-w-[250px] font-medium leading-relaxed">Nantinya Anda bisa memilih toko dan bernegosiasi harga grosir langsung di sini!</p>

            <button onclick="showChatMenu()" class="mt-8 bg-zinc-900 text-white px-6 py-2.5 rounded-full text-xs font-bold hover:bg-blue-600 transition-colors">
                Kembali ke Menu
            </button>
        </div>

        {{-- Voice Call Overlay --}}
        <div id="voice-call-overlay" class="absolute inset-0 bg-black/95 backdrop-blur-md z-[100] hidden flex-col items-center justify-center text-white">
            <div class="text-[10px] md:text-xs font-black tracking-widest text-zinc-500 uppercase mb-12 md:mb-16" id="voice-status-text">Menyambungkan...</div>
            <div class="relative w-24 h-24 md:w-32 md:h-32 flex items-center justify-center mb-12 md:mb-16">
                <div class="absolute inset-0 bg-blue-600/20 rounded-full animate-ping duration-1000"></div>
                <div id="voice-visualizer" class="w-20 h-20 md:w-24 md:h-24 rounded-full bg-blue-600 flex items-center justify-center text-white text-2xl md:text-3xl shadow-[0_0_30px_rgba(37,99,235,0.4)] z-10 transition-all duration-500">
                    <i class="fas fa-microphone"></i>
                </div>
            </div>
            <button onclick="endVoiceCallMode()" class="bg-zinc-900 border border-zinc-800 text-white hover:text-red-500 hover:border-red-500 px-6 py-2.5 md:px-8 md:py-3 rounded-full font-bold flex items-center gap-2 transition-all group text-xs md:text-sm outline-none">
                <i class="fas fa-phone-slash group-hover:animate-bounce"></i> Tutup Panggilan
            </button>
        </div>
    </div>

    {{-- Script Global Gabungan --}}
    <script>
        function landingPageData() {
            return {
                showPopup: false,
                initPage() {
                    const popupEnabled = "{{ $settings['enable_welcome_popup'] ?? '0' }}" === "1";
                    const freq = "{{ $settings['popup_frequency'] ?? 'always' }}";

                    if (popupEnabled) {
                        if (freq === 'always') {
                            this.showPopup = true;
                        } else if (freq === 'once_a_day') {
                            const lastSeen = localStorage.getItem('popup_last_seen');
                            const today = new Date().toDateString();
                            if (lastSeen !== today) {
                                this.showPopup = true;
                                localStorage.setItem('popup_last_seen', today);
                            }
                        }
                    }

                    setTimeout(() => initSlider(), 100);
                    setTimeout(() => typeEffect(), 100);
                },
                closePopup() {
                    this.showPopup = false;
                }
            }
        }

        // Logic Countdown Timer untuk Flash Sale
        document.addEventListener('alpine:init', () => {
            Alpine.data('countdown', (targetDate) => ({
                hours: '00', minutes: '00', seconds: '00',
                init() {
                    let target = new Date(targetDate).getTime();
                    if (isNaN(target)) {
                        target = new Date().getTime() + (2 * 60 * 60 * 1000);
                    }

                    setInterval(() => {
                        const now = new Date().getTime();
                        const distance = target - now;
                        if (distance < 0) {
                            this.hours = '00'; this.minutes = '00'; this.seconds = '00';
                            return;
                        }
                        this.hours = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
                        this.minutes = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                        this.seconds = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');
                    }, 1000);
                }
            }));
        });

        /* === DYNAMIC BANNER SLIDER LOGIC === */
        const slider = document.getElementById('hero-slider');
        const dotsContainer = document.getElementById('slider-dots');
        let currentSlide = 0;
        let totalSlides = slider ? slider.children.length : 0;
        let slideInterval;

        function initSlider() {
            if(totalSlides <= 1) return;
            for(let i=0; i<totalSlides; i++) {
                const dot = document.createElement('button');
                dot.className = `w-1.5 h-1.5 md:w-2 md:h-2 rounded-full transition-all duration-300 outline-none ${i === 0 ? 'w-4 md:w-6 bg-blue-500' : 'bg-white/40 hover:bg-white'}`;
                dot.onclick = () => goToSlide(i);
                dotsContainer.appendChild(dot);
            }
            startSlideShow();
        }

        function updateDots() {
            if(!dotsContainer) return;
            Array.from(dotsContainer.children).forEach((dot, index) => {
                dot.className = `w-1.5 h-1.5 md:w-2 md:h-2 rounded-full transition-all duration-300 outline-none ${index === currentSlide ? 'w-4 md:w-6 bg-blue-500' : 'bg-white/40 hover:bg-white'}`;
            });
        }

        function goToSlide(index) {
            currentSlide = index;
            slider.style.transform = `translateX(-${currentSlide * 100}%)`;
            updateDots();
            resetSlideShow();
        }

        function moveSlider(direction) {
            currentSlide = (currentSlide + direction + totalSlides) % totalSlides;
            goToSlide(currentSlide);
        }

        function startSlideShow() { slideInterval = setInterval(() => moveSlider(1), 5000); }
        function resetSlideShow() { clearInterval(slideInterval); startSlideShow(); }

        /* === TYPEWRITER EFFECT === */
        const typingText = document.querySelector(".typing-text");
        const phrases = ["Material Terlengkap", "Harga Pabrik Langsung", "Logistik Real-Time"];
        let phraseIndex = 0, charIndex = 0, isDeleting = false, typeSpeed = 100;

        function typeEffect() {
            if (!typingText) return;
            const currentPhrase = phrases[phraseIndex];
            if (isDeleting) {
                typingText.textContent = currentPhrase.substring(0, charIndex - 1);
                charIndex--; typeSpeed = 30;
            } else {
                typingText.textContent = currentPhrase.substring(0, charIndex + 1);
                charIndex++; typeSpeed = 80;
            }
            if (!isDeleting && charIndex === currentPhrase.length) {
                isDeleting = true; typeSpeed = 2500;
            } else if (isDeleting && charIndex === 0) {
                isDeleting = false; phraseIndex = (phraseIndex + 1) % phrases.length; typeSpeed = 500;
            }
            setTimeout(typeEffect, typeSpeed);
        }

        /* === CHAT HUB LOGIC === */
        const chatWindow = document.getElementById('live-chat-window');
        const menuView = document.getElementById('chat-menu-view');
        const aiView = document.getElementById('chat-ai-view');
        const sellerView = document.getElementById('chat-seller-view');

        const headerTitle = document.getElementById('chat-header-title');
        const headerSubtitle = document.getElementById('chat-header-subtitle');
        const headerIcon = document.getElementById('chat-header-icon');
        const headerPing = document.getElementById('chat-header-ping');
        const backBtn = document.getElementById('chat-back-btn');
        const callBtn = document.getElementById('chat-call-btn');

        function toggleChatWindow() {
            if(chatWindow.classList.contains('hidden')) {
                showChatMenu(); // Selalu buka menu awal
                chatWindow.classList.remove('hidden', 'opacity-0', 'translate-y-10', 'scale-95', 'pointer-events-none');
                chatWindow.classList.add('flex', 'opacity-100', 'translate-y-0', 'scale-100');
            } else {
                chatWindow.classList.add('opacity-0', 'translate-y-10', 'scale-95', 'pointer-events-none');
                chatWindow.classList.remove('opacity-100', 'translate-y-0', 'scale-100');
                setTimeout(() => chatWindow.classList.add('hidden'), 500);
                endVoiceCallMode();
            }
        }

        function showChatMenu() {
            menuView.classList.remove('hidden'); menuView.classList.add('flex');
            aiView.classList.remove('flex'); aiView.classList.add('hidden');
            sellerView.classList.remove('flex'); sellerView.classList.add('hidden');

            backBtn.classList.remove('flex'); backBtn.classList.add('hidden');
            callBtn.classList.remove('flex'); callBtn.classList.add('hidden');
            headerPing.classList.add('hidden');

            headerTitle.innerText = "Pusat Obrolan";
            headerSubtitle.innerText = "Pilih Layanan";
            headerIcon.innerHTML = '<i class="fas fa-comments text-blue-500 text-sm md:text-base"></i>';
        }

        function openChatAI() {
            menuView.classList.add('hidden'); menuView.classList.remove('flex');
            aiView.classList.remove('hidden'); aiView.classList.add('flex');

            backBtn.classList.remove('hidden'); backBtn.classList.add('flex');
            callBtn.classList.remove('hidden'); callBtn.classList.add('flex');
            headerPing.classList.remove('hidden');

            headerTitle.innerText = "Mandor POTA";
            headerSubtitle.innerText = "AI Proyek Aktif";
            headerIcon.innerHTML = '<i class="fas fa-hard-hat text-blue-500 text-sm md:text-base"></i>';

            setTimeout(() => document.getElementById('chat-input').focus(), 100);
        }

        function openChatSeller() {
            menuView.classList.add('hidden'); menuView.classList.remove('flex');
            sellerView.classList.remove('hidden'); sellerView.classList.add('flex');

            backBtn.classList.remove('hidden'); backBtn.classList.add('flex');

            headerTitle.innerText = "Chat Penjual";
            headerSubtitle.innerText = "Negosiasi B2B";
            headerIcon.innerHTML = '<i class="fas fa-store text-emerald-500 text-sm md:text-base"></i>';
        }

        function toggleFullScreen() {
            chatWindow.classList.toggle('sm:w-[360px]');
            chatWindow.classList.toggle('md:w-[380px]');
            chatWindow.classList.toggle('h-[75vh]');
            chatWindow.classList.toggle('md:h-[580px]');
            chatWindow.classList.toggle('w-[90vw]');
            chatWindow.classList.toggle('h-[85vh]');

            const icon = document.getElementById('icon-resize');
            icon.className = chatWindow.classList.contains('w-[90vw]') ? 'fas fa-compress text-xs md:text-sm' : 'fas fa-expand text-xs md:text-sm';
        }

        /* === CHATBOT POTA LOGIC === */
        const messagesContainer = document.getElementById('chat-messages');
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
                    chatInput.value = text;
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
            voiceBtn.classList.add('text-white', 'bg-blue-600', 'animate-pulse');
            voiceBtn.classList.remove('text-zinc-500', 'bg-zinc-100');
        }

        function stopRecordingUI() {
            voiceBtn.classList.remove('text-white', 'bg-blue-600', 'animate-pulse');
            voiceBtn.classList.add('text-zinc-500', 'bg-zinc-100');
        }

        function startVoiceCallMode() {
            if(!recognition) return alert("Browser tidak mendukung.");
            isCallMode = true;
            callOverlay.classList.remove('hidden'); callOverlay.classList.add('flex');
            voiceStatus.innerText = "Mandor Standby...";
            voiceVisualizer.classList.add('animate-pulse');
            speakText("Halo! Ada proyek apa hari ini?", true);
        }

        function endVoiceCallMode() {
            isCallMode = false;
            callOverlay.classList.add('hidden'); callOverlay.classList.remove('flex');
            window.speechSynthesis.cancel();
            if(recognition) recognition.stop();
        }

        function startListening() {
            if(!isCallMode) return;
            try {
                recognition.start();
                voiceStatus.innerText = "Silakan bicara...";
                voiceVisualizer.classList.add('animate-pulse');
            } catch(e) {}
        }

        function appendMessage(text, sender) {
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
        }

        async function sendMessage(textOverride = null) {
            const text = textOverride || chatInput.value.trim();
            if(!text) return;
            if(!textOverride) { appendMessage(text, 'user'); chatInput.value = ''; }
            chatHistory.push({sender:'user', text:text});

            if(!isCallMode) {
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
                    voiceVisualizer.classList.remove('animate-pulse');
                    voiceStatus.innerText = "Mandor Menjawab...";
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
</body>
</html>
