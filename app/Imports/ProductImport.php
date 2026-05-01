<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class ProductImport implements ToCollection, WithHeadingRow
{
    /**
     * Memproses data dari Excel baris per baris
     */
    public function collection(Collection $rows)
    {
        // Ambil ID Toko user yang sedang login
        $toko = DB::table('tb_toko')->where('user_id', Auth::id())->first();

        foreach ($rows as $row) {
            // Lewati baris kalau nama_barang di excel kosong
            if (!isset($row['nama_barang']) || empty($row['nama_barang'])) {
                continue;
            }

            // Masukkan ke database tb_barang
            DB::table('tb_barang')->insert([
                'toko_id'         => $toko->id,
                'kategori_id'     => $row['kategori_id'] ?? 1, // Pastikan ada kategori default
                'nama_barang'     => $row['nama_barang'],
                'kode_barang'     => $row['kode_barang'] ?? Str::random(8),
                'harga'           => $row['harga'] ?? 0,
                'stok'            => $row['stok'] ?? 0,
                'berat_kg'        => $row['berat_kg'] ?? 1,
                'satuan_unit'     => $row['satuan_unit'] ?? 'pcs',
                'deskripsi'       => $row['deskripsi'] ?? 'Deskripsi otomatis dari Excel.',

                // DATA DEFAULT UNTUK IMPORT EXCEL
                'gambar_utama'    => 'default.jpg',
                'is_active'       => 0,         // <-- INI DIA BOS! Otomatis OFF Etalase
                'status_moderasi' => 'pending', // <-- Otomatis nunggu di-ACC Admin

                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }
    }
}
