<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ChatController extends Controller
{
    /**
     * 1. MENGAMBIL DAFTAR KONTAK (TOKO) UNTUK CUSTOMER
     * Logika Dewa: Menarik data toko, gabung dengan pesan terakhir, hitung unread.
     */
    public function getContacts()
    {
        // Mengambil ID user yang sedang login dari tabel tb_user[cite: 1]
        $userId = Auth::id();

        // Subquery untuk mencari ID pesan terakhir di setiap chat room[cite: 1]
        $latestMessages = DB::table('messages')
            ->select('chat_id', DB::raw('MAX(id) as last_msg_id'))
            ->groupBy('chat_id');

        // Main Query: Gabungkan tabel chats, tb_toko, dan messages[cite: 1]
        $contactsQuery = DB::table('chats')
            ->join('tb_toko', 'chats.toko_id', '=', 'tb_toko.id')
            ->joinSub($latestMessages, 'latest_msg', function ($join) {
                $join->on('chats.id', '=', 'latest_msg.chat_id');
            })
            ->join('messages', 'messages.id', '=', 'latest_msg.last_msg_id')
            ->where('chats.customer_id', $userId)
            ->select(
                'tb_toko.id as store_id',
                'tb_toko.nama_toko',
                'tb_toko.logo_toko',
                'messages.message_text',
                'messages.message_type',
                'messages.timestamp as last_time',
                // Hitung pesan yang belum dibaca (is_read = 0) dan dikirim oleh orang lain[cite: 1]
                DB::raw("(SELECT COUNT(*) FROM messages m2 WHERE m2.chat_id = chats.id AND m2.is_read = 0 AND m2.sender_id != {$userId}) as unread_count")
            )
            ->orderByDesc('messages.timestamp')
            ->get();

        // Format data untuk dikirim ke UI Vue/Blade
        $contacts = $contactsQuery->map(function ($chat) {
            // Tentukan preview pesan berdasarkan tipe (Gambar, File, Audio)
            $previewText = $chat->message_text;
            if ($chat->message_type === 'image') $previewText = '📷 Mengirim Gambar';
            if ($chat->message_type === 'audio') $previewText = '🎤 Voice Note';
            if ($chat->message_type === 'file')  $previewText = '📄 Mengirim Dokumen';

            return [
                'store_id' => $chat->store_id,
                'nama_toko' => $chat->nama_toko,
                'logo_toko' => $chat->logo_toko,
                'last_message' => $previewText,
                'last_time' => $this->formatChatTime($chat->last_time),
                'unread_count' => $chat->unread_count
            ];
        });

        return response()->json($contacts);
    }

    /**
     * 2. MENGAMBIL HISTORI PESAN DENGAN TOKO TERTENTU
     */
    public function getMessages($storeId)
    {
        $userId = Auth::id(); // Referensi tabel tb_user[cite: 1]

        // Cek apakah room chat sudah ada di tabel chats[cite: 1]
        $chatRoom = DB::table('chats')
            ->where('customer_id', $userId)
            ->where('toko_id', $storeId)
            ->first();

        if (!$chatRoom) {
            return response()->json([]); // Belum ada histori chat
        }

        // Tandai pesan dari lawan bicara sebagai sudah dibaca (is_read = 1)[cite: 1]
        DB::table('messages')
            ->where('chat_id', $chatRoom->id)
            ->where('sender_id', '!=', $userId)
            ->where('is_read', 0)
            ->update([
                'is_read' => 1,
                'read_at' => Carbon::now()
            ]);

        // Ambil histori pesan dari tabel messages[cite: 1]
        $messagesQuery = DB::table('messages')
            ->where('chat_id', $chatRoom->id)
            ->orderBy('timestamp', 'asc')
            ->get();

        $messages = $messagesQuery->map(function ($msg) use ($userId) {
            // Tentukan isi konten (Teks biasa atau URL gambar/file/voice note)[cite: 1]
            $content = $msg->message_type === 'text' ? $msg->message_text : $msg->file_url;

            return [
                'sender' => ($msg->sender_id == $userId) ? 'user' : 'seller',
                'content' => $content,
                'type' => $msg->message_type,
                'fileName' => $msg->message_type === 'file' ? $msg->message_text : '',
                'time' => Carbon::parse($msg->timestamp)->format('H:i')
            ];
        });

        return response()->json($messages);
    }

    /**
     * 3. MENGIRIM PESAN BARU (TEKS, GAMBAR, FILE, VOICE NOTE)
     */
    public function sendMessage(Request $request)
    {
        $userId = Auth::id(); // Berelasi dengan customer_id[cite: 1]
        $storeId = $request->input('store_id'); // Berelasi dengan toko_id[cite: 1]
        $rawMessage = $request->input('message');
        $msgType = $request->input('type', 'text');

        $messageText = $rawMessage;
        $fileUrl = null;

        // DB Transaction untuk menjamin data tersimpan sempurna[cite: 1]
        DB::beginTransaction();
        try {
            // 1. Dapatkan atau Buat Room Chat (Tabel chats)[cite: 1]
            $chatRoom = DB::table('chats')
                ->where('customer_id', $userId)
                ->where('toko_id', $storeId)
                ->first();

            if (!$chatRoom) {
                $chatId = DB::table('chats')->insertGetId([
                    'customer_id' => $userId,
                    'toko_id' => $storeId,
                    'status' => 'open',
                    'start_time' => Carbon::now()
                ]);
            } else {
                $chatId = $chatRoom->id;
            }

            // 2. Logika Pemrosesan Media (Base64 ke File Fisik)
            if (in_array($msgType, ['image', 'audio', 'file']) && preg_match('/^data:(\w+\/[\w+-.]+);base64,/', $rawMessage, $matches)) {
                $mimeType = $matches[1];
                $extensions = [
                    'image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp',
                    'audio/webm' => 'webm', 'audio/mp3' => 'mp3', 'audio/wav' => 'wav', 'audio/ogg' => 'ogg',
                    'application/pdf' => 'pdf', 'application/zip' => 'zip'
                ];

                $extension = $extensions[$mimeType] ?? 'bin';
                // Potong string 'data:image/...;base64,' untuk mendapatkan data murni
                $fileData = base64_decode(substr($rawMessage, strpos($rawMessage, ',') + 1));

                $fileName = 'chat_' . time() . '_' . uniqid() . '.' . $extension;
                $storagePath = 'chat_media/' . $fileName;

                // Simpan ke storage Laravel (storage/app/public/chat_media)
                Storage::disk('public')->put($storagePath, $fileData);

                $fileUrl = '/storage/' . $storagePath; // Path URL untuk diakses UI

                // Jika itu file dokumen, simpan nama aslinya di message_text
                $messageText = $msgType === 'file' ? ($request->input('file_name') ?? 'Dokumen') : '';
            }

            // 3. Insert ke Tabel Messages (Sesuai upgrade kolom terbaru)[cite: 1]
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

            return response()->json([
                'status' => 'success',
                'reply' => $msgType === 'text' ? $messageText : $fileUrl,
                'time' => date('H:i')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * FUNGSI HELPER: Format Waktu Ala WhatsApp/Shopee
     */
    private function formatChatTime($timestamp)
    {
        $date = Carbon::parse($timestamp);
        if ($date->isToday()) {
            return $date->format('H:i'); // Tampilkan 10:45
        } elseif ($date->isYesterday()) {
            return 'Kemarin';
        } else {
            return $date->format('d/m/y'); // Tampilkan 12/05/26
        }
    }
}
