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
        // KAMUS MASTER EKSPEDISI RAJAONGKIR (BUKAN DUMMY)
        // Ini adalah kamus kode resmi yang dikenali oleh API RajaOngkir.
        // Karena API tidak bisa mendeteksi tipe akun (Starter/Pro),
        // Admin bebas mengaktifkan kurir sesuai paket yang sedang dibeli dari UI.
        // =========================================================================
        $api_couriers = [
            'jne'      => ['name' => 'JNE Express', 'type' => 'Reguler & Kargo', 'icon' => 'mdi-truck-fast'],
            'pos'      => ['name' => 'POS Indonesia', 'type' => 'Reguler', 'icon' => 'mdi-postbox'],
            'tiki'     => ['name' => 'TIKI', 'type' => 'Reguler', 'icon' => 'mdi-truck-outline'],
            'jnt'      => ['name' => 'J&T Express', 'type' => 'Reguler & Cargo', 'icon' => 'mdi-truck-delivery'],
            'sicepat'  => ['name' => 'SiCepat', 'type' => 'Reguler & Kargo', 'icon' => 'mdi-lightning-bolt'],
            'ninja'    => ['name' => 'Ninja Xpress', 'type' => 'Reguler', 'icon' => 'mdi-ninja'],
            'lion'     => ['name' => 'Lion Parcel', 'type' => 'Reguler', 'icon' => 'mdi-airplane-takeoff'],
            'anteraja' => ['name' => 'AnterAja', 'type' => 'Reguler', 'icon' => 'mdi-truck-check'],
            'indah'    => ['name' => 'Indah Logistik', 'type' => 'Kargo Berat', 'icon' => 'mdi-truck-flatbed'],
            'wahana'   => ['name' => 'Wahana Express', 'type' => 'Kargo & Ekonomi', 'icon' => 'mdi-weight-kilogram'],
            'sap'      => ['name' => 'SAP Express', 'type' => 'Reguler', 'icon' => 'mdi-map-marker-path'],
            'ide'      => ['name' => 'ID Express', 'type' => 'Reguler', 'icon' => 'mdi-truck-fast-outline'],
            'sentral'  => ['name' => 'Sentral Cargo', 'type' => 'Kargo', 'icon' => 'mdi-package-variant-closed'],
            'rex'      => ['name' => 'REX Express', 'type' => 'Kargo', 'icon' => 'mdi-truck-cargo-container'],
        ];

        return view('admin.logistics.index', compact('settings', 'api_couriers'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token']);

        // Data kurir yang dicentang oleh admin akan disimpan ke database
        $data['api_active_couriers'] = isset($request->couriers) ? json_encode($request->couriers) : json_encode([]);
        unset($data['couriers']);

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

        foreach ($data as $key => $value) {
            DB::table('tb_pengaturan')->updateOrInsert(
                ['setting_nama' => $key],
                ['setting_nilai' => $value]
            );
        }

        return back()->with('success', 'Regulasi dan Pengaturan Logistik berhasil diperbarui.');
    }
}
