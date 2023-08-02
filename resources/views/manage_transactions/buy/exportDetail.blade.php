<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Transaksi</title>
    <style>
        #myTable thead, #myTable tbody,  #myTable tr,  #myTable th, #myTable td{
            border: 1px solid black;
        }
    </style>
</head>

<body style="background-color:white">
    <table>
        <tr>
            <td>
                Detail Riwayat Transaksi
            </td>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            <td>Kode Transaksi</td>
            <td>:</td>
            <td>{{ $history->transaction_code }}</td>
        </tr>
        <tr>
            <td>Distributor</td>
            <td>:</td>
            <td>
            @if(auth()->user()->user_position != "reseller")
                Pabrik
            @else
                {{ $history->distributor->firstname }} {{ $history->distributor->lastname }}
            @endif
            </td>
        </tr>
        <tr>
            <td>Total</td>
            <td>:</td>
            <td>Rp. {{ number_format($history->total, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>:</td>
            <td>
                @if($history->status_pesanan == 1)
                    Sukses
                @else
                    Menunggu Konfirmasi
                @endif
            </td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td>{{ $history->updated_at->format('d/m/y H:i:s') }}</td>
        </tr>
        <tr>
            <td>Jumlah Barang</td>
            <td>:</td>
            <td>{{ $history->jumlah_barang }}</td>
        </tr>
    </table>
    <br>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $count = 0;
            @endphp
            @foreach($details as $detail)
            @php
                $count++;
            @endphp
            <tr>
                <td>{{ $count }}</td>
                <td>{{ $detail->nama_produk }}</td>
                <td>{{ number_format($detail->jumlah, 0, ',', '.') }} pcs</td>
                <td>Rp. {{ number_format($detail->harga, 0, ',', '.') }}</td>
                <td>Rp. {{ number_format($detail->total, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>