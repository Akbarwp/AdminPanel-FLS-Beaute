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
                Input Pasok Barang
            </div>
            <hr style="border-color:black;"><br>
            <div class="container justify text-center">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-12 grid-margin">
                        <div class="iq-card">
                            <div class="iq-card-body">
                                <div class="table-responsive-xl" style="overflow: scroll;">
                                    <table cellspacing="0" id="myTable" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Kode Pasok</th>
                                                <th>Nama Pasok</th>
                                                <th>Total Pasok</th>
                                                <th>Admin</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $totalPembelian = 0;
                                            @endphp
                                            @foreach($histories as $history)
                                                <tr>
                                                    <td>{{ $history->created_at->format('j F Y H:m:s') }}</td>
                                                    <td>{{ $history->kode_pasok }}</td>
                                                    <td>{{ $history->nama_supplier }}</td>
                                                    <td>Rp {{ number_format($history->total, 0, ',', '.') }}</td>
                                                    <td>
                                                        {{ $history->nama_input }}
                                                    </td>
                                                </tr>
                                                @php
                                                $totalPembelian += $history->total;
                                            @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div><br>
                                    <table>
                                        <tr>
                                            <td>Total Pembelian Pasok Barang</td>
                                            <td>:</td>
                                            <td>Rp. {{ number_format($totalPembelian, 0, ',', '.') }}</td>
                                        </tr>
                                    </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
