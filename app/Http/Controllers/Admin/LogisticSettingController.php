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
// =========================================================================
        // DATA REAL SESUAI API RAJAONGKIR (PAKET PRO / ENTERPRISE)
        // Gunakan ini jika sudah langganan paket berbayar RajaOngkir
        // =========================================================================
        $api_couriers = [
            // EKSPEDISI KARGO (B2B Material)
            'indah'    => ['name' => 'Indah Logistik', 'type' => 'Spesialis Kargo Berat', 'icon' => 'mdi-truck-flatbed'],
            'wahana'   => ['name' => 'Wahana Express', 'type' => 'Kargo & Ekonomi', 'icon' => 'mdi-weight-kilogram'],
            'sentral'  => ['name' => 'Sentral Cargo', 'type' => 'Kargo Darat/Udara', 'icon' => 'mdi-package-variant-closed'],
            'rex'      => ['name' => 'REX Express', 'type' => 'Kargo & Reguler', 'icon' => 'mdi-truck-cargo-container'],

            // EKSPEDISI REGULER & JARINGAN LUAS
            'jne'      => ['name' => 'JNE Express', 'type' => 'Reguler & Kargo (JTR)', 'icon' => 'mdi-truck-fast'],
            'jnt'      => ['name' => 'J&T Express', 'type' => 'Reguler & J&T Cargo', 'icon' => 'mdi-truck-delivery'],
            'sicepat'  => ['name' => 'SiCepat', 'type' => 'Reguler & Gokil (Kargo)', 'icon' => 'mdi-lightning-bolt'],
            'pos'      => ['name' => 'POS Indonesia', 'type' => 'Reguler & Jumbo', 'icon' => 'mdi-postbox'],
            'tiki'     => ['name' => 'TIKI', 'type' => 'Reguler & TRC', 'icon' => 'mdi-truck-outline'],

            // EKSPEDISI LAINNYA
            'ninja'    => ['name' => 'Ninja Xpress', 'type' => 'Reguler', 'icon' => 'mdi-ninja'],
            'anteraja' => ['name' => 'AnterAja', 'type' => 'Reguler & Kargo', 'icon' => 'mdi-truck-check'],
            'lion'     => ['name' => 'Lion Parcel', 'type' => 'Reguler', 'icon' => 'mdi-airplane-takeoff'],
            'sap'      => ['name' => 'SAP Express', 'type' => 'Reguler', 'icon' => 'mdi-map-marker-path'],
            'ide'      => ['name' => 'ID Express', 'type' => 'Reguler', 'icon' => 'mdi-truck-fast-outline'],
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
