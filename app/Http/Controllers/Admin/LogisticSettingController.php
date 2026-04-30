<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogisticSettingController extends Controller
{
    public function index()
    {
        // Ambil semua pengaturan logistik dari database
        $settingsData = DB::table('tb_pengaturan')->get();
        $settings = [];
        foreach ($settingsData as $row) {
            $settings[$row->setting_nama] = $row->setting_nilai;
        }

        // =========================================================================
        // DATA REAL SESUAI API RAJAONGKIR (PAKET STARTER)
        // Paket Starter HANYA mendukung 3 kurir ini. Jangan tambahkan kurir lain.
        // =========================================================================
        $api_couriers = [
            'jne'  => ['name' => 'JNE Express', 'type' => 'Reguler, OKE, YES', 'icon' => 'mdi-truck-fast'],
            'pos'  => ['name' => 'POS Indonesia', 'type' => 'Kilat Khusus, Express', 'icon' => 'mdi-postbox'],
            'tiki' => ['name' => 'TIKI', 'type' => 'Reguler, ONS, ECO', 'icon' => 'mdi-truck-outline'],
        ];

        return view('admin.logistics.index', compact('settings', 'api_couriers'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token']);

        // Konversi checkbox kurir API menjadi JSON
        $data['api_active_couriers'] = isset($request->couriers) ? json_encode($request->couriers) : json_encode([]);
        unset($data['couriers']); // Hapus array asli agar tidak masuk DB langsung

        // Handle Toggle Switch (Jika off, POST tidak mengirim data, jadi kita set 0 manual)
        // PERBAIKAN: Menambahkan toggle pickup dan asuransi agar tidak error saat dimatikan
        $toggles = [
            'enable_store_pickup',
            'enable_custom_fleet',
            'enable_emergency_delivery',
            'force_insurance'
        ];

        foreach ($toggles as $toggle) {
            if (!isset($data[$toggle])) {
                $data[$toggle] = '0';
            }
        }

        // Simpan ke database tb_pengaturan
        foreach ($data as $key => $value) {
            DB::table('tb_pengaturan')->updateOrInsert(
                ['setting_nama' => $key],
                ['setting_nilai' => $value]
            );
        }

        return back()->with('success', 'Regulasi dan Pengaturan Logistik berhasil diperbarui.');
    }
}
