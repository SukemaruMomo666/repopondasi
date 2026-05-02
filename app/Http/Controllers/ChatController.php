<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // 1. Mengambil Daftar Kontak (Toko yang pernah di-chat)
    public function getContacts()
    {
        $userId = Auth::id(); // Pastikan user login

        // LOGIKA DEWA: Ambil daftar toko, gabungkan dengan pesan terakhir, dan hitung pesan belum dibaca
        // Ganti 'tb_toko' dan 'tb_chat' sesuai nama tabel asli Bos di database

        /* CONTOH QUERY REAL (Silakan sesuaikan):
        $contacts = DB::select("
            SELECT
                t.id as store_id,
                t.nama_toko,
                t.logo_toko,
                (SELECT pesan FROM tb_chat WHERE toko_id = t.id AND user_id = ? ORDER BY created_at DESC LIMIT 1) as last_message,
                (SELECT created_at FROM tb_chat WHERE toko_id = t.id AND user_id = ? ORDER BY created_at DESC LIMIT 1) as last_time,
                (SELECT COUNT(id) FROM tb_chat WHERE toko_id = t.id AND user_id = ? AND is_read = 0 AND sender = 'seller') as unread_count
            FROM tb_toko t
            JOIN tb_chat c ON c.toko_id = t.id
            WHERE c.user_id = ?
            GROUP BY t.id
            ORDER BY last_time DESC
        ", [$userId, $userId, $userId, $userId]);
        */

        // DUMMY RESPONSE UNTUK TESTING UI (Hapus jika query asli sudah jalan)
        $contacts = [
            [
                'store_id' => 1,
                'nama_toko' => 'PT Baja Nusantara',
                'logo_toko' => null,
                'last_message' => 'Pesanan 100 sak semen sudah di jalan bos.',
                'last_time' => '10:13',
                'unread_count' => 2
            ],
            [
                'store_id' => 2,
                'nama_toko' => 'TB. Sinar Jaya',
                'logo_toko' => null,
                'last_message' => 'Sama-sama kak.',
                'last_time' => 'Rabu',
                'unread_count' => 0
            ]
        ];

        return response()->json($contacts);
    }

    // 2. Mengambil Histori Chat dengan Toko Tertentu
    public function getMessages($storeId)
    {
        // Ambil dari DB: SELECT * FROM tb_chat WHERE toko_id = $storeId AND user_id = Auth::id()

        $messages = [
            ['sender' => 'seller', 'text' => 'Halo Bos! Ada yang bisa dibantu?', 'time' => '10:00'],
            ['sender' => 'user', 'text' => 'Besi beton 12mm ready 50 batang?', 'time' => '10:05'],
            ['sender' => 'seller', 'text' => 'Ready bos, mau dikirim kapan?', 'time' => '10:13'],
        ];

        return response()->json($messages);
    }

    // 3. Mengirim Pesan Baru ke Toko
    public function sendMessage(Request $request)
    {
        $text = $request->input('message');
        $storeId = $request->input('store_id');

        // INSERT INTO tb_chat (user_id, toko_id, sender, pesan, is_read, created_at) VALUES (...)

        return response()->json(['status' => 'success', 'message' => $text, 'time' => date('H:i')]);
    }
}
