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
        $toko = DB::table('tb_toko')->where('user_id', Auth::id())->first();

        foreach ($rows as $row) {
            if (!isset($row['nama_barang']) || empty(trim($row['nama_barang']))) {
                continue;
            }

            DB::table('tb_barang')->insert([
                'toko_id'         => $toko->id,
                'kategori_id'     => $row['kategori_id'] ?? 1,
                'nama_barang'     => $row['nama_barang'],
                'kode_barang'     => $row['kode_barang'] ?? Str::random(8),
                'harga'           => $row['harga'] ?? 0,
                'stok'            => $row['stok'] ?? 0,
                'berat_kg'        => $row['berat_kg'] ?? 0,

                // --- INI PERBAIKANNYA BOS! (Tidak pakai null lagi) ---
                'satuan_unit'     => !empty($row['satuan_unit']) ? $row['satuan_unit'] : 'pcs',
                'deskripsi'       => !empty($row['deskripsi']) ? $row['deskripsi'] : 'Deskripsi belum tersedia.',
                // -----------------------------------------------------

                'gambar_utama'    => 'default.jpg',
                'is_active'       => 0,
                'status_moderasi' => 'pending',
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }
    }
}
