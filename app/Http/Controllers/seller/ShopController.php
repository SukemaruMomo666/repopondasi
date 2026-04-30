<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    /**
     * Helper untuk selalu mendapatkan toko yang valid
     */
    private function getToko()
    {
        $toko = DB::table('tb_toko')->where('user_id', Auth::id())->first();
        if (!$toko) {
            abort(403, 'Akses Ditolak: Anda belum memiliki data Toko.');
        }
        return $toko;
    }

    /**
     * ==========================================
     * 1. MANAJEMEN PROFIL TOKO
     * ==========================================
     */
    public function profile()
    {
        $toko = $this->getToko();
        return view('seller.shop.profile', compact('toko'));
    }

    public function updateProfile(Request $request)
    {
        // 1. Ambil Data Toko
        $toko = DB::table('tb_toko')->where('user_id', Auth::id())->first();
        if (!$toko) {
            abort(403, 'Akses Ditolak: Anda belum memiliki data Toko.');
        }

        // 2. Validasi Form
        $request->validate([
            'nama_toko'       => 'required|string|max:50',
            'slogan'          => 'nullable|string|max:100',
            'deskripsi_toko'  => 'nullable|string|max:1000',
            'catatan_toko'    => 'nullable|string|max:2000',
            'kebijakan_retur' => 'nullable|string|max:2000',
            'no_telepon'      => 'required|string|max:20',
            'alamat_lengkap'  => 'required|string|max:255',
            'province_id'     => 'required|integer',
            'city_id'         => 'required|integer',
            'district_id'     => 'required|integer',
            'kode_pos'        => 'nullable|numeric|digits_between:5,6',
            'latitude'        => 'nullable|string|max:50',
            'longitude'       => 'nullable|string|max:50',
            'logo_toko'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'banner_toko'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'dokumen_nib'     => 'nullable|file|mimes:pdf,jpeg,png,jpg,webp|max:5120',
            'dokumen_npwp'    => 'nullable|file|mimes:pdf,jpeg,png,jpg,webp|max:5120',
        ]);

        // 3. Mapping Data (NAMA KIRI ADALAH KOLOM DATABASE ASLI)
        $dataUpdate = [
            'nama_toko'       => $request->nama_toko,
            'slogan'          => $request->slogan,
            'deskripsi_toko'  => $request->deskripsi_toko,  // <-- INI YANG BENAR (Bukan 'deskripsi')
            'catatan_toko'    => $request->catatan_toko,
            'kebijakan_retur' => $request->kebijakan_retur,
            'telepon_toko'    => $request->no_telepon,      // <-- INI YANG BENAR (Bukan 'no_telepon')
            'alamat_toko'     => $request->alamat_lengkap,  // <-- INI YANG BENAR (Bukan 'alamat_lengkap')
            'province_id'     => $request->province_id,
            'city_id'         => $request->city_id,
            'district_id'     => $request->district_id,
            'kode_pos'        => $request->kode_pos,
            'latitude'        => $request->latitude,
            'longitude'       => $request->longitude,
            'updated_at'      => now()
        ];

        // 4. Handle Logo Baru
        if ($request->hasFile('logo_toko')) {
            $logo = $request->file('logo_toko');
            $logoName = 'logo_' . \Illuminate\Support\Str::random(10) . '.' . $logo->getClientOriginalExtension();

            if (!empty($toko->logo_toko)) {
                $oldPath = public_path('assets/uploads/logos/' . $toko->logo_toko);
                if (\Illuminate\Support\Facades\File::exists($oldPath)) { \Illuminate\Support\Facades\File::delete($oldPath); }
            }

            if(!\Illuminate\Support\Facades\File::exists(public_path('assets/uploads/logos'))) { \Illuminate\Support\Facades\File::makeDirectory(public_path('assets/uploads/logos'), 0777, true); }
            $logo->move(public_path('assets/uploads/logos'), $logoName);
            $dataUpdate['logo_toko'] = $logoName;
        }

        // 5. Handle Banner Baru
        if ($request->hasFile('banner_toko')) {
            $banner = $request->file('banner_toko');
            $bannerName = 'banner_' . \Illuminate\Support\Str::random(10) . '.' . $banner->getClientOriginalExtension();

            if (!empty($toko->banner_toko)) {
                $oldBannerPath = public_path('assets/uploads/banners/' . $toko->banner_toko);
                if (\Illuminate\Support\Facades\File::exists($oldBannerPath)) { \Illuminate\Support\Facades\File::delete($oldBannerPath); }
            }

            if(!\Illuminate\Support\Facades\File::exists(public_path('assets/uploads/banners'))) { \Illuminate\Support\Facades\File::makeDirectory(public_path('assets/uploads/banners'), 0777, true); }
            $banner->move(public_path('assets/uploads/banners'), $bannerName);
            $dataUpdate['banner_toko'] = $bannerName;
        }

        // 6. Handle Dokumen Legalitas (NIB & NPWP)
        $legalPath = public_path('assets/uploads/legalitas');
        if(!\Illuminate\Support\Facades\File::exists($legalPath)) { \Illuminate\Support\Facades\File::makeDirectory($legalPath, 0777, true); }

        if ($request->hasFile('dokumen_nib')) {
            $nib = $request->file('dokumen_nib');
            $nibName = 'NIB_' . $toko->id . '_' . \Illuminate\Support\Str::random(5) . '.' . $nib->getClientOriginalExtension();
            if (!empty($toko->dokumen_nib) && \Illuminate\Support\Facades\File::exists($legalPath . '/' . $toko->dokumen_nib)) { \Illuminate\Support\Facades\File::delete($legalPath . '/' . $toko->dokumen_nib); }
            $nib->move($legalPath, $nibName);
            $dataUpdate['dokumen_nib'] = $nibName;
        }

        if ($request->hasFile('dokumen_npwp')) {
            $npwp = $request->file('dokumen_npwp');
            $npwpName = 'NPWP_' . $toko->id . '_' . \Illuminate\Support\Str::random(5) . '.' . $npwp->getClientOriginalExtension();
            if (!empty($toko->dokumen_npwp) && \Illuminate\Support\Facades\File::exists($legalPath . '/' . $toko->dokumen_npwp)) { \Illuminate\Support\Facades\File::delete($legalPath . '/' . $toko->dokumen_npwp); }
            $npwp->move($legalPath, $npwpName);
            $dataUpdate['dokumen_npwp'] = $npwpName;
        }

        // 7. Eksekusi Update
        DB::table('tb_toko')->where('id', $toko->id)->update($dataUpdate);

        return redirect()->route('seller.shop.profile')->with('success', 'Profil Toko & Legalitas B2B berhasil diperbarui!');
    }

    /**
     * ==========================================
     * 2. PENGATURAN TOKO & KEAMANAN
     * ==========================================
     */
    public function settings()
    {
        $user = Auth::user();
        $toko = $this->getToko();

        $notif = json_decode($toko->notifikasi_settings ?? '{}', true) ?: [
            'email_pesanan' => true,
            'email_promo'   => false,
            'push_chat'     => true,
        ];

        return view('seller.shop.settings', compact('user', 'toko', 'notif'));
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();
        $toko = $this->getToko();

        // TAB KEAMANAN: Ganti Password
        if ($request->has('form_type') && $request->form_type == 'security') {
            $request->validate([
                'current_password' => 'required',
                'new_password'     => 'required|min:8|confirmed',
            ]);

            // Cek Password Lama
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->with('error', 'Password saat ini salah!');
            }

            // Update Password Baru
            DB::table('tb_user')
                ->where('id', $user->id)
                ->update(['password' => Hash::make($request->new_password)]);

            return redirect()->back()->with('success', 'Password berhasil diperbarui!');
        }

        // TAB PENGATURAN UMUM: Status Libur & Notifikasi
        if ($request->has('form_type') && $request->form_type == 'general') {
            $isVacation = $request->has('status_libur') ? 1 : 0;

            $notifSettings = json_encode([
                'email_pesanan' => $request->has('notif_email_pesanan'),
                'email_promo'   => $request->has('notif_email_promo'),
                'push_chat'     => $request->has('notif_push_chat'),
            ]);

            DB::table('tb_toko')->where('id', $toko->id)->update([
                'status_libur'        => $isVacation,
                'pesan_otomatis'      => $request->pesan_otomatis,
                'notifikasi_settings' => $notifSettings,
                'updated_at'          => now()
            ]);

            return redirect()->back()->with('success', 'Pengaturan toko berhasil disimpan!');
        }

        return redirect()->back()->with('error', 'Permintaan tidak valid.');
    }

    /**
     * ==========================================
     * 3. DEKORASI TOKO (DRAG & DROP LOGIC)
     * ==========================================
     */

    // Halaman Landing Dekorasi (Pilih Mobile/Desktop)
    public function decoration()
    {
        $toko = $this->getToko();

        $defaultLayout = [
            ['id' => 'banner_promo', 'type' => 'banner', 'title' => 'Banner Promo Utama', 'image' => null],
            ['id' => 'kategori_pilihan', 'type' => 'kategori', 'title' => 'Kategori Pilihan', 'items' => []],
            ['id' => 'produk_terlaris', 'type' => 'produk', 'title' => 'Produk Terlaris', 'items' => []]
        ];

        // Mencegah error null pointer jika layout belum ada
        $layoutData = empty($toko->layout_data) ? $defaultLayout : json_decode($toko->layout_data, true);

        return view('seller.shop.decoration', compact('toko', 'layoutData'));
    }

    // Halaman Pemilihan Template
    public function templateSelection()
    {
        $toko = $this->getToko();
        return view('seller.shop.template-selection', compact('toko'));
    }

    // Halaman Editor Drag & Drop (Mobile)
    public function editor()
    {
        $toko = $this->getToko();
        return view('seller.shop.editor', compact('toko'));
    }

    // Halaman Editor Desktop KITA
    public function editorDesktop()
    {
        $toko = $this->getToko();
        return view('seller.shop.editor-desktop', compact('toko'));
    }

    /**
     * Update susunan dekorasi via AJAX (Mobile / Versi Lama)
     */
    public function updateDecoration(Request $request)
    {
        $request->validate([
            'layout_data' => 'required|array'
        ]);

        $toko = $this->getToko();

        DB::table('tb_toko')->where('id', $toko->id)->update([
            'layout_data' => json_encode($request->layout_data),
            'updated_at'  => now()
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Dekorasi toko berhasil disimpan!'
        ]);
    }

    /**
     * FUNGSI SAKTI PENYIMPANAN DESKTOP EDITOR
     */
    public function saveDecoration(Request $request)
    {
        $toko = DB::table('tb_toko')->where('user_id', Auth::id())->first();

        if (!$toko) {
            return response()->json(['success' => false, 'message' => 'Toko tidak ditemukan.']);
        }

        // Pastikan menyimpan sebagai raw string (karena JSON Payload)
        DB::table('tb_toko')->where('id', $toko->id)->update([
            'dekorasi_desktop' => json_encode($request->all()),
            'updated_at'       => now()
        ]);

        return response()->json(['success' => true, 'message' => 'Dekorasi berhasil ditayangkan!']);
    }
}
