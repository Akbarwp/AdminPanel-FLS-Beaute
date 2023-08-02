<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FLS Beauty</title>
    <style>
        #myTable thead, #myTable tbody,  #myTable tr,  #myTable th, #myTable td{
            border: 1px solid black;
        }
    </style>
</head>

<body style="background-color:white">
    <div class="wrapper">
        <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <table style="width:100%;">
                    <tr style="width:100%;">
                        <td style="width:20%;">
                            <?php $image_path = '/images/flslogo.jpg'; ?>
                                <img src="{{ public_path() . $image_path }}" style="width:75%">
                        </td>
                                            
                        <td style="text-align: right; width:80%;">
                            <div class="d-flex justify-content-end" style="font-weight:bold; ">
                                    PT ANDARA CANTIKA
                            </div>
                            <div class="d-flex justify-content-end">
                                    Pergudangan Bumi Benowo Sukses Sejahtera Tbk
                            </div>
                            <div class="d-flex justify-content-end">
                                    Jl. Raya Gelora Bung Tomo No. 8, Surabaya, Jawa Timur
                            </div>
                            <div class="d-flex justify-content-end">
                                    Email: flsbeautyofficial@gmail.com
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <hr style="border-color:black;">
                <div class="row d-flex justify-content-center" style="font-weight:bold; font-size:24px; text-align:center">
                    {{ $product->product_type->nama_produk }}
                </div>
            <hr style="border-color:black;">
            <h5 style="text-align:left;font-weight:bold;">Daftar Barang Pusat - Keluar - Januari 2022</h5> 
            <div class="container justify text-center">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-12 grid-margin">
                        <div class="iq-card">
                            <div class="iq-card-body">
                                <div class="table-responsive-xl" style="overflow: scroll; ">
                                    <table id="myTable" cellspacing="0" style="width: 100%">
                                        <thead>
                                            <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                                @if(auth()->user()->user_position == "reseller")
                                                    <th>Tanggal Keluar</th>
                                                    <th>No Transaksi</th>
                                                    <th>Jumlah barang Keluar</th>
                                                @else
                                                    <th>Tanggal Keluar</th>
                                                    <th>Admin</th>
                                                    <th>No Transaksi</th>
                                                    <th>Jumlah barang Keluar</th>
                                                @endif
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                                $totalKeluar=0;
                                            @endphp
                                            @foreach($keluar as $k)
                                                <tr>
                                                    @if(auth()->user()->user_position == "reseller")
                                                        <td>{{ $k->created_at->format('d/m/y H:i:s') }}</td>
                                                        <td>{{ $k->nama_toko }}</td>
                                                        <td>{{ number_format($k->jumlah_produk, 0, ',', '.') }} pcs</td>
                                                        @php
                                                            $totalKeluar+=$k->jumlah_produk;
                                                        @endphp
                                                    @else
                                                        <td>{{ $k->updated_at->format('d/m/y H:i:s') }}</td>
                                                        <td>{{ $k->nama_approve }}</td>
                                                        <td>{{ $k->transaction_code }}</td>
                                                        <td>{{ number_format($k->jumlah, 0, ',', '.') }} pcs</td>
                                                        @php
                                                            $totalKeluar+=$k->jumlah;
                                                        @endphp
                                                    @endif
                                                </tr>
                                            @endforeach
                                            @if(auth()->user()->id_group != 1)
                                                @foreach($keluarKasir as $k)
                                                    <tr>
                                                        @if(auth()->user()->user_position == "reseller")
                                                            <td>{{ $k->updated_at->format('d/m/y H:i:s') }}</td>
                                                            <td>{{ $k->transaction_code }}</td>
                                                            <td>{{ number_format($k->jumlah, 0, ',', '.') }} pcs</td>
                                                        @else
                                                            <td>{{ $k->updated_at->format('d/m/y H:i:s') }}</td>
                                                            <td>{{ $k->nama_input }}</td>
                                                            <td>{{ $k->transaction_code }}</td>
                                                            <td>{{ number_format($k->jumlah, 0, ',', '.') }} pcs</td>
                                                        @endif
                                                    </tr>
                                                    @php
                                                        $totalKeluar+=$k->jumlah;
                                                    @endphp
                                                @endforeach
                                            @endif
                                            @foreach($keluarRetur as $k)
                                                <tr>
                                                    <td>{{ $k->updated_at->format('d/m/y H:i:s') }}</td>
                                                    <td>{{ $k->nama_input }}</td>
                                                    <td>{{ $k->surat_keluar }}</td>
                                                    <td>{{ number_format($k->jumlah, 0, ',', '.') }} pcs</td>
                                                </tr>
                                                @php
                                                    $totalKeluar+=$k->jumlah;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <br>
                                    <p style="font-weight:bold">Jumlah Barang Keluar : {{ number_format($totalKeluar, 0, ',', '.') }} pcs</p>
                                </div>
                                <div class="table-responsive-xl" style="overflow: scroll;">
                                    <h5 style="text-align:left;font-weight:bold;">Daftar Barang Pusat - Masuk - Januari 2022</h5>
                                    <table cellspacing="0" id="myTable2" style="width: 100%">
                                        <thead>
                                            <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                                @if(auth()->user()->id_group == 1)
                                                <th>Tanggal Masuk</th>
                                                <th>Admin</th>
                                                <th>Kode Pasok</th>
                                                <th>Jumlah barang Masuk</th>
                                                @elseif(auth()->user()->user_position == "reseller")
                                                <th>Tanggal Masuk</th>
                                                <th>No. Transaksi</th>
                                                <th>Jumlah barang Masuk</th>
                                                @else
                                                <th>Tanggal Masuk</th>
                                                <th>Admin</th>
                                                <th>No. Transaksi</th>
                                                <th>Jumlah barang Masuk</th>
                                                @endif
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                                $totalMasuk=0;
                                            @endphp
                                            @foreach($masuk as $m)
                                            <tr>
                                                @if(auth()->user()->id_group == 1)
                                                <td>{{ $m->updated_at->format('d/m/y H:i:s') }}</td>
                                                <td>{{ $m->nama_input }}</td>
                                                <td>{{ $m->kode_pasok }}</td>
                                                <td>{{ number_format($m->jumlah, 0, ',', '.') }} pcs</td>
                                                @elseif(auth()->user()->user_position == "reseller")
                                                <td>{{ $m->updated_at->format('d/m/y H:i:s') }}</td>
                                                <td>{{ $m->transaction_code }}</td>
                                                <td>{{ number_format($m->jumlah, 0, ',', '.') }} pcs</td>
                                                @else
                                                <td>{{ $m->updated_at->format('d/m/y H:i:s') }}</td>
                                                <td>{{ $m->nama_input }}</td>
                                                <td>{{ $m->transaction_code }}</td>
                                                <td>{{ number_format($m->jumlah, 0, ',', '.') }} pcs</td>
                                                @endif
                                            </tr>
                                            @php
                                                $totalMasuk+=$m->jumlah;
                                            @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <br>
                                    <p style="font-weight:bold">Jumlah Barang Masuk : {{ number_format($totalMasuk, 0, ',', '.') }} pcs</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>                                    