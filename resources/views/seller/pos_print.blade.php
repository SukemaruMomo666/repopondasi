<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk POS - {{ $transaksi->kode_invoice }}</title>
    <style>
        /* CSS Khusus Printer Thermal Kasir */
        @page { margin: 0; }
        body {
            font-family: 'Courier New', Courier, monospace; /* Font ala kasir */
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 20px;
            background: #fff;
            width: 80mm; /* Standar kertas kasir, ubah ke 58mm jika printer kecil */
            margin-left: auto;
            margin-right: auto;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }
        .dashed-line { border-top: 1px dashed #000; margin: 10px 0; }
        .table-items { width: 100%; border-collapse: collapse; margin: 10px 0; }
        .table-items td { padding: 3px 0; vertical-align: top; }
        .store-name { font-size: 18px; font-weight: bold; text-transform: uppercase; margin-bottom: 5px; }
        .store-address { font-size: 10px; margin-bottom: 10px; line-height: 1.4; }
        
        /* Hilangkan padding saat ngeprint betulan */
        @media print {
            body { width: 100%; padding: 0; }
        }
    </style>
</head>
<!-- Fungsi onload="window.print()" akan otomatis membuka dialog print browser -->
<body onload="window.print()">
    
    <div class="text-center">
        <div class="store-name">{{ $toko->nama_toko }}</div>
        <div class="store-address">
            {{ $toko->alamat_toko }}<br>
            Telp: {{ $toko->telepon_toko }}
        </div>
    </div>
    
    <div class="dashed-line"></div>
    
    <table style="width: 100%; font-size: 11px;">
        <tr>
            <td width="30%">No</td>
            <td width="5%">:</td>
            <td>{{ $transaksi->kode_invoice }}</td>
        </tr>
        <tr>
            <td>Tgl</td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td style="vertical-align: top;">Info</td>
            <td style="vertical-align: top;">:</td>
            <td>{{ $transaksi->catatan }}</td>
        </tr>
    </table>
    
    <div class="dashed-line"></div>
    
    <table class="table-items">
        @foreach($details as $item)
        <tr>
            <td colspan="3" class="font-bold">{{ $item->nama_barang_saat_transaksi }}</td>
        </tr>
        <tr>
            <td width="25%">{{ $item->jumlah }}x</td>
            <td width="35%">{{ number_format($item->harga_saat_transaksi, 0, ',', '.') }}</td>
            <td width="40%" class="text-right">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>
    
    <div class="dashed-line"></div>
    
    <table class="table-items" style="font-size: 14px;">
        <tr>
            <td class="font-bold">TOTAL:</td>
            <td class="text-right font-bold">Rp {{ number_format($transaksi->total_final, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="dashed-line"></div>
    
    <div class="text-center" style="margin-top: 20px; font-size: 10px; line-height: 1.5;">
        *** TERIMA KASIH ***<br>
        Barang yang sudah dibeli tidak<br>
        dapat ditukar/dikembalikan.
    </div>

</body>
</html>