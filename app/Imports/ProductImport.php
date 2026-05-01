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
            // Lewati baris kalau nama_barang di excel benar-benar kosong
            if (!isset($row['nama_barang']) || empty(trim($row['nama_barang']))) {
                continue;
            }

            DB::table('tb_barang')->insert([
                'toko_id'         => $toko->id,
                'kategori_id'     => $row['kategori_id'] ?? 1,
                'nama_barang'     => $row['nama_barang'],
                'kode_barang'     => $row['kode_barang'] ?? Str::random(8),
                'harga'           => $row['harga'] ?? 0,

                // ==========================================
                // DIBUAT OPSIONAL (NOL / NULL) SESUAI REQUEST
                // ==========================================
                'stok'            => $row['stok'] ?? 0,
                'berat_kg'        => $row['berat_kg'] ?? 0,
                'satuan_unit'     => $row['satuan_unit'] ?? null,
                'deskripsi'       => $row['deskripsi'] ?? null,
                // ==========================================

                'gambar_utama'    => 'default.jpg',
                'is_active'       => 0,         // Otomatis OFF Etalase
                'status_moderasi' => 'pending', // Nunggu approval

                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }
    }
}
