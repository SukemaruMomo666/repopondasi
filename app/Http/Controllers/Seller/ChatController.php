<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ChatController extends Controller
{
    /**
     * 1. Menampilkan Halaman UI Chat Seller
     */
    public function chat()
    {
        return view('seller.chat');
    }

    /**
     * 2. API: Mengambil Daftar Kontak Pelanggan (Sebelah Kiri)
     */
    public function getChatList()
    {
        $userId = Auth::id(); // Seller's user ID

        // 1. Dapatkan Toko milik Seller
        $toko = DB::table('tb_toko')->where('user_id', $userId)->first();

        if (!$toko) {
            return response()->json(['status' => 'error', 'message' => 'Toko tidak ditemukan.']);
        }

        // 2. Subquery: Ambil ID pesan terakhir untuk setiap chat room
        $latestMessages = DB::table('messages')
            ->select('chat_id', DB::raw('MAX(id) as last_msg_id'))
            ->groupBy('chat_id');

        // 3. Query Utama: Ambil data chat room, info pelanggan, dan pesan terakhir
        $chatsQuery = DB::table('chats')
            ->join('tb_user', 'chats.customer_id', '=', 'tb_user.id')
            // Gunakan leftJoinSub agar chat room tanpa pesan tetap muncul jika perlu
            ->leftJoinSub($latestMessages, 'latest_msg', function ($join) {
                $join->on('chats.id', '=', 'latest_msg.chat_id');
            })
            ->leftJoin('messages', 'messages.id', '=', 'latest_msg.last_msg_id')
            ->where('chats.toko_id', $toko->id)
            ->select(
                'chats.id',
                'tb_user.nama as nama_pelanggan',
                'messages.message_text',
                'messages.message_type',
                'messages.timestamp as last_time',
                // Hitung pesan yang belum dibaca dari pelanggan (sender != seller's user_id)
                DB::raw("(SELECT COUNT(*) FROM messages m2 WHERE m2.chat_id = chats.id AND m2.is_read = 0 AND m2.sender_id != {$userId}) as unread_count")
            )
            ->orderByRaw('messages.timestamp DESC NULLS LAST') // Urutkan yang terbaru di atas
            ->get();

        // 4. Format data untuk Frontend
        $formattedChats = $chatsQuery->map(function ($chat) {
            // Tentukan preview pesan
            $preview = $chat->message_text;
            if ($chat->message_type === 'image') $preview = '📷 Mengirim Gambar';
            if ($chat->message_type === 'audio') $preview = '🎤 Voice Note';
            if ($chat->message_type === 'file')  $preview = '📄 Mengirim Dokumen';

            // Jika belum ada pesan sama sekali
            if (!$preview) $preview = 'Belum ada pesan.';

            return [
                'id' => $chat->id,
                'nama_pelanggan' => $chat->nama_pelanggan,
                'last_message' => $preview,
                'time_display' => $chat->last_time ? $this->formatTime($chat->last_time) : '',
                'unread_count' => $chat->unread_count
            ];
        });

        return response()->json(['status' => 'success', 'data' => $formattedChats]);
    }

    /**
     * 3. API: Mengambil Histori Pesan di Ruang Chat Tertentu (Sebelah Kanan)
     */
    public function getMessages($chatId)
    {
        $userId = Auth::id();

        // Verifikasi kepemilikan toko & chat
        $toko = DB::table('tb_toko')->where('user_id', $userId)->first();

        if (!$toko) {
            return response()->json(['status' => 'error', 'message' => 'Toko tidak valid.'], 403);
        }

        $chatRoom = DB::table('chats')
            ->where('id', $chatId)
            ->where('toko_id', $toko->id)
            ->first();

        if (!$chatRoom) {
            return response()->json(['status' => 'error', 'message' => 'Akses ditolak.'], 403);
        }

        // Tandai pesan dari pelanggan sebagai "Telah Dibaca"
        DB::table('messages')
            ->where('chat_id', $chatId)
            ->where('sender_id', '!=', $userId) // Jika sender BUKAN seller ini
            ->where('is_read', 0)
            ->update([
                'is_read' => 1,
                'read_at' => Carbon::now()
            ]);

        // Ambil histori pesan
        $messages = DB::table('messages')
            ->where('chat_id', $chatId)
            ->orderBy('timestamp', 'asc')
            ->get()
            ->map(function ($msg) use ($userId) {
                // Tentukan isi konten: Teks biasa atau URL File
                $content = $msg->message_type === 'text' ? $msg->message_text : $msg->file_url;

                return [
                    'is_mine' => ($msg->sender_id == $userId), // True jika yang kirim adalah Seller
                    'text' => $content, // Menggunakan key 'text' agar sesuai dengan JS di frontend seller
                    'content' => $content, // Menyediakan 'content' juga untuk berjaga-jaga
                    'type' => $msg->message_type,
                    'fileName' => $msg->message_type === 'file' ? $msg->message_text : '',
                    'time' => Carbon::parse($msg->timestamp)->format('H:i')
                ];
            });

        return response()->json(['status' => 'success', 'data' => $messages]);
    }

    /**
     * 4. API: Mengirim Pesan (Teks, Gambar, File, Voice Note)
     */
    public function sendMessage(Request $request)
    {
        $userId = Auth::id();
        $chatId = $request->input('chat_id');

        // Frontend mengirim 'message_text' untuk teks biasa
        // Jika media (gambar/audio/file) mungkin dikirim dengan format base64 di key yang berbeda
        // Mari kita periksa key 'message_text' dan 'message'
        $rawMessage = $request->input('message_text') ?? $request->input('message');

        $msgType = $request->input('type', 'text');
        $fileNameParam = $request->input('file_name');

        if (!$rawMessage) {
            return response()->json(['status' => 'error', 'message' => 'Pesan tidak boleh kosong.'], 400);
        }

        $messageText = $rawMessage;
        $fileUrl = null;

        // Cek validitas ruang chat
        $toko = DB::table('tb_toko')->where('user_id', $userId)->first();
        $chatRoom = DB::table('chats')
            ->where('id', $chatId)
            ->where('toko_id', $toko->id)
            ->first();

        if (!$chatRoom) {
            return response()->json(['status' => 'error', 'message' => 'Chat Room tidak valid'], 400);
        }

        DB::beginTransaction();
        try {
            // PROSES KONVERSI BASE64 KE FILE FISIK JIKA TIPE = MEDIA
            if (in_array($msgType, ['image', 'audio', 'file']) && preg_match('/^data:(\w+\/[\w+-.]+);base64,/', $rawMessage, $matches)) {
                $mimeType = $matches[1];

                // Mapping Ekstensi
                $extensions = [
                    'image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp',
                    'audio/webm' => 'webm', 'audio/mp3' => 'mp3', 'audio/ogg' => 'ogg',
                    'application/pdf' => 'pdf', 'application/zip' => 'zip',
                    'application/msword' => 'doc', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
                    'application/vnd.ms-excel' => 'xls', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx'
                ];

                $extension = $extensions[$mimeType] ?? 'bin';

                // Decode File
                $fileData = base64_decode(substr($rawMessage, strpos($rawMessage, ',') + 1));

                // Buat Nama File Unik
                $generateName = 'seller_' . time() . '_' . uniqid() . '.' . $extension;
                $storagePath = 'chat_media/' . $generateName;

                // Simpan ke Storage Laravel (public/chat_media)
                Storage::disk('public')->put($storagePath, $fileData);

                $fileUrl = '/storage/' . $storagePath;
                $messageText = $msgType === 'file' ? ($fileNameParam ?? 'Dokumen') : '';
            } elseif ($msgType === 'text') {
                // Pastikan untuk teks biasa, file_url null
                $fileUrl = null;
            }

            // SIMPAN KE DATABASE
            DB::table('messages')->insert([
                'chat_id' => $chatId,
                'sender_id' => $userId,
                'message_text' => $messageText,
                'message_type' => $msgType,
                'file_url' => $fileUrl,
                'is_read' => 0,
                'timestamp' => Carbon::now()
            ]);

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Pesan terkirim']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * FORMAT WAKTU HELPER
     */
    private function formatTime($timestamp)
    {
        if (!$timestamp) return '';

        $date = Carbon::parse($timestamp);
        if ($date->isToday()) return $date->format('H:i');
        if ($date->isYesterday()) return 'Kemarin';
        return $date->format('d/m/y');
    }
}
